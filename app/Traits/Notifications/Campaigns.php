<?php

namespace App\Traits\Notifications;

use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

trait Campaigns
{
    function getCampaigns($nodes, $filter = '')
    {
        return Campaign::with('notification')
        ->whereHas('notification', function($query) use($nodes){
            if(is_array($nodes))
                $query->whereIn('NOT_NODO_ID', $nodes);
            else
                $query->where('NOT_NODO_ID', $nodes);
        })
        ->when($filter, function($query) use ($filter){
            return $query->where('CAMP_NOMBRE', 'like', "%{$filter}%");
        })
        ->orderBy('CAMP_TS', 'desc');

    }

    function getCampaignStats($campId)
    {
        $tokDB = DB::connection('reportes');
        $result = cache()->remember('estadisticas-campana-' . $campId, 60*60*5, function() use($tokDB, $campId){
            return $tokDB->table('dat_notificacion')
            ->join('dat_campush', 'dat_notificacion.NOT_ID', '=', 'dat_campush.CAMP_NOT_ID')
            ->join('dat_notificacion_usuario', 'dat_notificacion.NOT_ID', '=', 'dat_notificacion_usuario.NOT_USU_NOTIFICACION_ID')
            ->selectRaw("CAMP_NOMBRE, IF(CAMP_EXITOSAS > 0, CAMP_EXITOSAS , 0) CAMP_EXITOSAS, IF(CAMP_FALLIDAS > 0, CAMP_FALLIDAS, 0) CAMP_FALLIDAS,
              IF(CAMP_ANDROID > 0, CAMP_ANDROID, 0) CAMP_ANDROID, IF(CAMP_IOS > 0, CAMP_IOS, 0) CAMP_IOS, SUM(IF(NOT_USU_ESTADO = '0', 1, 0)) NO_LEIDAS, SUM(IF(NOT_USU_ESTADO = '1', 1, 0)) LEIDAS, SUM(IF(NOT_USU_ESTADO = '2', 1, 0)) ELIMINADAS")
            ->where('CAMP_ID', '=', $campId)
            ->first();
        });

        return $result;
    }

    function programCampaign($data)
    {
        $tokDB = DB::connection('tokencash_campanas');
        $ts = date('Y-m-d H:i:s');
        list($fecha, $hora) = explode(' ', $data['datetime']);
        try
        {
            $tokDB->table('dat_notificacion_programada')
            ->insert([
                'NOT_PROG_TS'  => $ts,
                'NOT_PROG_UTS' => $ts,
                'NOT_PROG_NOT_ID' => $data['campaign'],
                'NOT_PROG_FECHA_PROG' => $fecha,
                'NOT_PROG_STATUS' => 'PENDIENTE',
                'NOT_PROG_HORA_PROG' => date('H:i', strtotime($hora)),
            ]);

            return true;
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            //dd($e);
            return false;
        }

    }

    /** Guardar una nueva campaña */
    function insertCampaign($data)
    {
        //dd($data);
        $query = "SELECT
                    NOD_USU_ID,
                    NOD_USU_CONFIGURACION

                FROM
                    cat_dbm_nodos_usuarios
                INNER JOIN
                    bal_tae_saldos
                ON
                    NOD_USU_NODO = TAE_SAL_NODO
                WHERE
                    TAE_SAL_BOLSA = '". $data['giftcard'] ."'
                AND
                    LENGTH(NOD_USU_CONFIGURACION) > (180)";

        if(isset($data['gender']))
        {
            switch($data['gender'])
            {
                case 'masculino' : $query .= " AND ((JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"H\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"h\")"; break;
                case 'femenino' : $query .= " AND ((JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"M\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"m\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"f\")"; break;
                case 'otro' : $query .= " AND ((JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"LGBT\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"lgtb\")"; break;
            }
        }

        if(isset($data['activity']))
        {
            $query .= " AND TIMESTAMPDIFF(DAY, TAE_SAL_UTS, NOW()) > " . $data['activity'] . "";
        }

        dd($query);

        //Guardar en dat_notificacion

        //Guardar en dat_campush

        //retornar
    }
}
