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

    function getCampaignStats($notId)
    {
        $tokDB = DB::connection('reportes');
        $result = $tokDB->table('dat_notificacion')
        ->join('dat_campush', 'dat_notificacion.NOT_ID', '=', 'dat_campush.CAMP_NOT_ID')
        ->join('dat_notificacion_usuario', 'dat_notificacion.NOT_ID', '=', 'dat_notificacion_usuario.NOT_USU_NOTIFICACION_ID')
        ->select(DB::raw("CAST(CONVERT(CAMP_NOMBRE USING utf8) AS binary) CAMP_NOMBRE, CAMP_EXITOSAS, CAMP_FALLIDAS, CAMP_ANDROID, CAMP_IOS, SUM(IF(NOT_USU_ESTADO = '0', 1, 0)) NO_LEIDAS, SUM(IF(NOT_USU_ESTADO = '1', 1, 0)) LEIDAS, SUM(IF(NOT_USU_ESTADO = '2', 1, 0)) ELIMINADAS"))
        ->where('NOT_ID', '=', $notId)
        ->first();

        return $result;
    }
}
