<?php

namespace App\Traits\Notifications;

use Illuminate\Support\Facades\DB;

trait Notifications
{
    function getTokencashNotificationUsers()
    {
        $numbers = ['3315745279', '3314096129', '3318981880', '3310078100', '3329570029', '3334671759', '3411077555', '3310478782'];
        $tokDB = DB::connection('reportes');
        return $tokDB->table('cat_dbm_nodos_usuarios')
        ->select(['NOD_USU_ID', 'NOD_USU_CONFIGURACION'])
        ->whereIn('NOD_USU_NUMERO', ['3315745279'])
        ->get();
    }

    function getNotification($idNotification)
    {
        $tokDB = DB::connection('reportes');
        return $tokDB->table('dat_notificacion')
        ->select(['NOD_ID', 'NOD_TITULO', 'NOT_CUERPO', 'NOT_ACCION', 'NOT_TIPO'])
        ->where('NOD_ID', $idNotification)
        ->get();
    }
}
