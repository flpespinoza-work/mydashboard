<?php

namespace App\Traits\Scores;
use Illuminate\Support\Facades\DB;

trait Scores
{
    function getScores($filters)
    {

        $scores = [];
        $filters['node'] = fnGetTokencashNode($filters['store']);
        $filters['initial_date'] = $filters['initial_date'] . ' 00:00:00';
        $filters['final_date'] = $filters['final_date'] . ' 23:59:59';
        if($filters['final_date'] < '2021-06-10')
        {
            $scores = $this->getOldScores($filters);
        }
        elseif($filters['initial_date'] > '2021-06-10')
        {
            $scores = $this->getNewScores($filters);
        }
        else
        {
            $filters_a = $filters;
            $filters_b = $filters;
            $filters_a['final_date'] = '2021-06-10 11:23:04';
            $filters_b['initial_date'] = '2021-06-10 11:23:05';
            $scores_new = $this->getNewScores($filters_b);
            $scores_old = $this->getOldScores($filters_a);
            $scores = array_merge_recursive($scores_old, $scores_new);
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
        $rememberReport = 60*60*8;
        $scores = cache()->remember('new-scores-report' . $reportID, $rememberReport, function() use($tokDB, $filters) {
            $result = [];
            $query = $tokDB->table('dat_comentarios')
            ->join('cat_dbm_nodos_usuarios', 'cat_dbm_nodos_usuarios.NOD_USU_ID', '=', 'dat_comentarios.COM_USUARIO_ID')
            ->select(['NOD_USU_NODO', 'COM_FECHA_HORA', 'COM_ESTABLECIMIENTO_ID', 'COM_TIPO', 'COM_COMENTARIO', 'COM_CALIFICACION', 'COM_VENDEDOR', 'COM_ADICIONAL'])
            ->where('COM_ESTABLECIMIENTO_ID', $filters['node'])
            ->whereBetween('COM_FECHA_HORA', [$filters['initial_date'], $filters['final_date']])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->where('COM_COMENTARIO', 'NOT LIKE', "%escribe tus comentarios aqu%")
            ->orderBy('COM_FECHA_HORA', 'desc');

            if($filters['seller'])
            {
                $query->where('COM_VENDEDOR', $filters['seller']);
            }

            $query->chunk(5000, function($scores) use(&$result) {
                foreach($scores as $score)
                {
                    $result['data'][] = [
                        'type' => 'new',
                        'date' => $score->COM_FECHA_HORA,
                        'user' => $score->NOD_USU_NODO,
                        'store' => $score->COM_ESTABLECIMIENTO_ID,
                        'action' => ($score->COM_TIPO == 'CANJE') ? 'Canje de cupon' : 'Pago con Tokencash',
                        'comment' => $score->COM_COMENTARIO,
                        'score' => $score->COM_CALIFICACION,
                        'seller' => $score->COM_VENDEDOR,
                        'aditional' => $score->COM_ADICIONAL
                    ];
                }
            });

            return $result;
            //return mb_convert_encoding($result, 'UTF-8', 'UTF-8');
        });
        return $scores;
    }

    //Nuevo query sin NOD_USU_CERTIFICADO  y filtrar en php

    function getOldScores($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportID = fnGenerateReportId($filters);
        $rememberReport = 60*60*8;
        $filters['giftcard'] = fnGetGiftcardFull($filters['store']);
        $filters['budget'] = fnGetBudgetFull($filters['store']);
        $scores = cache()->remember('old-scores-report' . $reportID, $rememberReport, function() use($tokDB, $filters) {
            $result = [];
            $query = $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_DESTINO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(['VEN_FECHA_HORA', 'VEN_NODO', 'VEN_DESTINO', 'VEN_ADICIONAL'])
            ->where(function($query) use($filters){
                $query->where('VEN_BOLSA', $filters['giftcard'])
                      ->orWhere('VEN_BOLSA', $filters['budget']);
            })
            ->where(function($query){
                $query->where('VEN_ADICIONAL', 'like', '%CALIFICACION%')
                      ->orWhere('VEN_ADICIONAL', 'like', '%COMENTARIOS%');
            })
            ->whereBetween('VEN_FECHA_HORA', [$filters['initial_date'], $filters['final_date']])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->where('VEN_ADICIONAL', 'NOT LIKE', "%escribe tus comentarios aqu%")
            ->orderBy('VEN_FECHA_HORA', 'desc');

            $query->chunk(5000, function($scores) use(&$result, $tokDB) {
                foreach($scores as $score)
                {
                    $action = '';
                    $seller = '';

                    //Tratar JSON si esta mal estructurado
                    $score->VEN_ADICIONAL = str_replace('REFERENCIA":"', 'REFERENCIA": [', $score->VEN_ADICIONAL);
                    $score->VEN_ADICIONAL = str_replace('","RECOMPENSA_PERMANENTE', '],"RECOMPENSA_PERMANENTE', $score->VEN_ADICIONAL);
                    $score->VEN_ADICIONAL = str_replace('\\', '', $score->VEN_ADICIONAL);
                    $score->VEN_ADICIONAL = utf8_encode($score->VEN_ADICIONAL);
                    //Convertir el adicional a array y obtener el tipo
                    $m_adicional = json_decode($score->VEN_ADICIONAL, true);
                    if(isset($m_adicional['CUPON_ID']))
                    {
                        $action = 'Canje de cupon';
                        $q = $tokDB->table('dat_cupones_adicional')->select('CUP_ADI_NAME')->where('CUP_ADI_CUPON', $m_adicional['CUPON_ID'])->first();
                        $seller = $q->CUP_ADI_NAME ?? '';
                    }
                    elseif(isset($m_adicional['TOKEN']))
                    {
                        $action = 'Pago con Tokencash';
                        $q = $tokDB->table('dat_token_adicional')->select('TOK_ADI_NAME')->join('doc_tokens', 'dat_token_adicional.TOK_ADI_TOKEN', '=', 'doc_tokens.TOK_ID')->where('TOK_TOKEN', $m_adicional['TOKEN'])->first();
                        $seller = $q->TOK_ADI_NAME ?? '';
                    }

                    $result['data'][] = [
                        'type' => 'old',
                        'date' => $score->VEN_FECHA_HORA,
                        'user' => $score->VEN_NODO,
                        'store' => $score->VEN_DESTINO,
                        'action' => $action,
                        'comment' => (isset($m_adicional['COMENTARIOS'])) ? utf8_encode(trim($m_adicional['COMENTARIOS'])) : '',
                        'score' => (isset($m_adicional['CALIFICACION']))? $m_adicional['CALIFICACION'] : '',
                        'seller' => $seller,
                        'aditional' => $score->VEN_ADICIONAL
                    ];
                }
            });

            return $result;
            //return mb_convert_encoding($result, 'UTF-8', 'UTF-8');
        });

        if(count($scores) && $filters['seller'])
        {
            $scores_filtered['data'] = array_filter($scores['data'], function($score) use ($filters){
                return $score['seller'] === $filters['seller'];
            });
            return $scores_filtered;
        }

        return $scores;
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
            return   $b['date'] <=> $a['date'];
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
                    $stars['comments'][$comment['score']][] = $comment;
                }
            }
            elseif((isset($comment['comment']) && !empty($comment['comment'])) && $commentRow < $commentsMax)
            {
                $stars['stars_N']++;
                $stars['count0']++;
                $stars['comments']['0'][] = $comment;
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
