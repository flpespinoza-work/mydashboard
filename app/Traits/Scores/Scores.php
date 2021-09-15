<?php

namespace App\Traits\Scores;
use Illuminate\Support\Facades\DB;

trait Scores
{
    function getScores($filters)
    {
        $scores = [];
        $filters['node'] = fnGetTokencashNode($filters['store']);

        if($filters['final_date'] < '2021-06-10')
        {
            $scores = $this->getOldScores($filters);
        }
        elseif($filters['initial_date'] > '2021-06-10')
        {
            $scores = $this->getNewScores($filters);
        }

        if(!empty($scores))
        {
            $scores = $this->orderScores($scores, $filters['final_date']);
            //Eliminar comentarios que contengan "Escribe tus comentarios aquí"
            foreach($scores['comments'] as $score => $commentList)
            {
                foreach($commentList as $key => $comment)
                {
                    if($comment['comment'] == 'Escribe tus comentarios aquí')
                    {
                        unset($scores['comments'][$score][$key]);
                    }
                }
            }
        }

        return $scores;
    }

    function getNewScores($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportID = fnGenerateReportId($filters);
        $rememberReport = fnRememberReportTime($filters['final_date']);
        $scores = cache()->remember('new-scores-report' . $reportID, $rememberReport, function() use($tokDB, $filters) {
            $result = [];
            $query = $tokDB->table('dat_comentarios')
            ->join('cat_dbm_nodos_usuarios', 'cat_dbm_nodos_usuarios.NOD_USU_ID', '=', 'dat_comentarios.COM_USUARIO_ID')
            ->select(['NOD_USU_NODO', 'COM_FECHA_HORA', 'COM_ESTABLECIMIENTO_ID', 'COM_TIPO', 'COM_COMENTARIO', 'COM_CALIFICACION', 'COM_VENDEDOR', 'COM_ADICIONAL'])
            ->where('COM_ESTABLECIMIENTO_ID', $filters['node'])
            ->whereBetween('COM_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->orderBy('COM_FECHA_HORA', 'desc');

            if($filters['seller'])
            {
                $query->where('COM_VENDEDOR', $filters['seller']);
            }

            $query->chunk(50, function($scores) use(&$result) {
                foreach($scores as $score)
                {
                    $result['data'][] = [
                        'type' => 'new',
                        'date' => $score->COM_FECHA_HORA,
                        'user' => $score->NOD_USU_NODO,
                        'store' => $score->COM_ESTABLECIMIENTO_ID,
                        'action' => ($score->COM_TIPO == 'CANJE') ? 'Canje de cupon' : 'Pago con Tokencash',
                        'comment' => utf8_encode($score->COM_COMENTARIO),
                        'score' => $score->COM_CALIFICACION,
                        'seller' => utf8_encode($score->COM_VENDEDOR),
                        'aditional' => $score->COM_ADICIONAL
                    ];
                }
            });

            return mb_convert_encoding($result, 'UTF-8', 'UTF-8');
        });

        return $scores;
    }

    function getOldScores($filters)
    {

    }

    //Ordenar calificaciones y comentarios
    function orderScores($scores, $finalDate)
    {
        //Ordenar por calificacion de mayor a menor
        usort($scores['data'], function($a, $b) {
            return $a['score'] <=> $b['score'];
        });
        //Ordenar por fecha
        usort($scores['data'], function($a, $b) {
            return $a['date'] <=> $b['date'];
        });

        $a_scoreValue = [
            'score_5' => 5,
            "score_4" => ($finalDate <= '2021-09-14') ? 3 : 3.3,
            "score_3" => 1,
            "score_2" => 0.5,
            "score_1" => -8
        ];

        $commentRow = 0;
        $commentsMax = 10000;
        $stars = array
        (
			"stars_1" => 0,
			"stars_2" => 0,
			"stars_3" => 0,
			"stars_4" => 0,
			"stars_5" => 0,
			"stars_N" => 0,
			"totalScores" => 0,
			"totalStars" => 0,
			"count5" => 0,
			"count4" => 0,
			"count3" => 0,
			"count2" => 0,
			"count1" => 0,
			"count0" => 0,
			"countX" => 0,
            "totalComments" => 0,
            "comments" => []
		);

        //Recorrer comentarios y obtener totales
        foreach($scores['data'] as $comment)
        {
            if($comment['comment'] != 'Escribe tus comentarios aquí')
            {
                $commentRow++;
                if($comment['score'] >= 1)
                {
                    $stars['totalScores']++;
                    $stars['totalStars'] += $a_scoreValue["score_{$comment['score']}"];
                    $stars['stars_' . $comment['score']]++;

                    if(isset($comment['comment']) && !empty($comment['comment']))
                    {
                        $stars['totalComments']++;
                        $stars['count' . $comment['score']]++;
                        if(!str_contains('Escribe tus comentarios', $comment['comment']))
                            $stars['comments'][$comment['score']][] = $comment;
                    }
                }
                elseif((isset($comment['comment']) && !empty($comment['comment'])) && $commentRow < $commentsMax)
                {
                    $stars['stars_N']++;
                    $stars['count0']++;
                    if(!str_contains('Escribe tus comentarios', $comment['comment']))
                        $stars['comments']['0'][] = $comment;
                }
            }
        }

        if($stars['totalStars'] > 0)
        {
            $stars['maxScore'] = $stars['totalScores'] * 5;
            $scorePromedio = ($stars['totalStars'] / $stars['maxScore']) * 100;
            $stars['scorePromedio'] = number_format($scorePromedio, 2);
        }

        //Ordenar comantarios en stars
        uksort($stars['comments'], function($a, $b){
            return $a <=> $b;
        });

        return $stars;

    }
}
