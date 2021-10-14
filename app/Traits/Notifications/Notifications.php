<?php

namespace App\Traits\Notifications;

use Illuminate\Support\Facades\DB;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;

trait Notifications
{
    function getTokencashNotificationUsers()
    {
        //$numbers = ['3315745279', '3314096129', '3318981880', '3310078100', '3329570029', '3334671759', '3411077555', '3310478782'];
        $tokDB = DB::connection('tokencash_campanas'); //Cambiar a reportes
        $result = $tokDB->table('cat_dbm_nodos_usuarios')
        ->select(['NOD_USU_ID', 'NOD_USU_CONFIGURACION'])
        ->whereIn('NOD_USU_NUMERO', ['3315745279'])
        ->get();

        foreach($result as $user)
        {
            $config = json_decode($user->NOD_USU_CONFIGURACION, true);
            $users[$user->NOD_USU_ID] = $config['INSTALACION_ID'];
        }

        return $users;
    }

    function getNotification($idNotification)
    {
        $tokDB = DB::connection('reportes');
        return $tokDB->table('dat_notificacion')
        ->select(['NOT_ID', 'NOT_TITULO', 'NOT_CUERPO', 'NOT_ACCION', 'NOT_TIPO'])
        ->where('NOT_ID', $idNotification)
        ->first();
    }

    function sendNotificationAlert($users, $notification)
    {
        $firebase = $this->initService();
        $action = json_decode($notification->NOT_ACCION, true);
        $actions = json_encode(['type' => 'info']);
        $apnsConfig = ApnsConfig::fromArray([
            'payload' =>
            [
                'aps' =>
                [
                    'category' => 'info',
                    'alert' =>
                    [
                        'title' => $notification->NOT_TITULO,
                        'body' => $notification->NOT_CUERPO
                    ],
                    'content-available' => 1,
                    'mutable-content' => 1
                ],
                'headers' =>
                [
                    'apns-collapse-id' => '1'
                ]
            ]
        ]);

        $message = CloudMessage::fromArray([
            'data' =>
            [
                'title' => $notification->NOT_TITULO,
                'id' => $notification->NOT_ID,
                'message' => $notification->NOT_CUERPO,
                'imageUrl' => $action['IMG'],
                'notificationId' => $notification->NOT_ID,
                'body' => $notification->NOT_CUERPO,
                'image' => $action['IMG'],
                'actions' => $actions,
                'action' => $actions,
                'read' => 'unread',
                'date' => date('d/m/Y'),
                'ID_NOTIFICACION' => $notification->NOT_ID,
                'TITULO' => $notification->NOT_TITULO,
                'CUERPO' => $notification->NOT_CUERPO
            ]
        ])
        ->withApnsConfig($apnsConfig);

        $firebase->sendMulticast($message, array_values($users));
    }

    function sendNotification($users, $notification, $type)
    {
        $firebase = $this->initService();
        if($type == 'informativa')
            $message = $this->getMessageInfo($notification);
        else
            $message = $this->getMessageCoupon($notification);

        //Obtener numero de dispositivos android e ios

        //Dividir usuarios en array de 300 elementos
        $devices = array_values($users);
        $errors = 0;
        $successes = 0;
        if(count($devices) > 500)
        {
            $devices_array = array_chunk($devices, 300);
            foreach($devices_array as $devices)
            {
                $resultNotification = $firebase->sendMulticast($message, $devices);
                $errors += $resultNotification->failures()->count();
                $successes += $resultNotification->successes()->count();
            }
        }
        else
        {
            $resultNotification = $firebase->sendMulticast($message, $devices);
            $errors += $resultNotification->failures()->count();
            $successes += $resultNotification->successes()->count();
        }

    }

    function getMessageInfo($notification)
    {
        $action = json_decode($notification->NOT_ACCION, true);
        $actions = json_encode(['type' => 'info']);
        $apnsConfig = ApnsConfig::fromArray([
            'payload' =>
            [
                'aps' =>
                [
                    'category' => 'info',
                    'alert' =>
                    [
                        'title' => $notification->NOT_TITULO,
                        'body' => $notification->NOT_CUERPO
                    ],
                    'content-available' => 1,
                    'mutable-content' => 1
                ],
                'headers' =>
                [
                    'apns-collapse-id' => '1'
                ]
            ]
        ]);

        return  CloudMessage::fromArray([
            'data' =>
            [
                'title' => $notification->NOT_TITULO,
                'id' => $notification->NOT_ID,
                'message' => $notification->NOT_CUERPO,
                'imageUrl' => $action['IMG'],
                'notificationId' => $notification->NOT_ID,
                'body' => $notification->NOT_CUERPO,
                'image' => $action['IMG'],
                'actions' => $actions,
                'action' => $actions,
                'read' => 'unread',
                'date' => date('d/m/Y'),
                'ID_NOTIFICACION' => $notification->NOT_ID,
                'TITULO' => $notification->NOT_TITULO,
                'CUERPO' => $notification->NOT_CUERPO
            ]
        ])
        ->withApnsConfig($apnsConfig);
    }

    function getMessageCoupon($notification)
    {
        $action = json_decode($notification->NOT_ACCION, true);
        $coupon = $action['CUPON'];
        $actions = json_encode(['type' => 'payCoupon', 'code' => $coupon]);

        $apnsConfig = ApnsConfig::fromArray([
            'payload' =>
            [
                'aps' =>
                [
                    'category' => 'payCoupon',
                    'alert' =>
                    [
                        'title' => $notification->NOT_TITULO,
                        'body' => $notification->NOT_CUERPO
                    ],
                    'content-available' => 1,
                    'mutable-content' => 1
                ],
                'headers' =>
                [
                    'apns-collapse-id' => '1'
                ]
            ]
        ]);

        return  CloudMessage::fromArray([
            'data' =>
            [
                'title' => $notification->NOT_TITULO,
                'id' => $notification->NOT_ID,
                'message' => $notification->NOT_CUERPO,
                'imageUrl' => $action['IMG'],
                'coupon' => $coupon,
                'notificationId' => $notification->NOT_ID,
                'body' => $notification->NOT_CUERPO,
                'image' => $action['IMG'],
                'actions' => $actions,
                'action' => $actions,
                'read' => 'unread',
                'date' => date('d/m/Y'),
                'ID_NOTIFICACION' => $notification->NOT_ID,
                'TITULO' => $notification->NOT_TITULO,
                'CUERPO' => $notification->NOT_CUERPO
            ]
        ])
        ->withApnsConfig($apnsConfig);
    }

    function initService()
    {
        $serviceAccount = ServiceAccount::fromValue(storage_path('firebase/tokencash_firebase_credentials.json'));
        return (new Factory)->withServiceAccount($serviceAccount)->createMessaging();
    }
}
