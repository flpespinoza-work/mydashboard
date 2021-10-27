<?php

namespace App\Traits\Notifications;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;

trait Notifications
{
    function getTokencashNotificationUsers()
    {
        //$numbers = ['3315745279', '3314096129', '3318981880', '3310078100', '3329570029', '3334671759', '3411077555', '3310478782'];
        $tokDB = DB::connection('reportes'); //Cambiar a reportes
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

    function getTokencashNotificationUser($numbers)
    {
        $numbers = explode(',', $numbers);
        $tokDB = DB::connection('reportes'); //Cambiar a reportes
        $usersDB = $tokDB->table('cat_dbm_nodos_usuarios')
        ->select(['NOD_USU_ID', 'NOD_USU_CONFIGURACION'])
        ->whereIn('NOD_USU_NUMERO', $numbers)
        ->get();

        foreach($usersDB as $userDB)
        {
            $config = json_decode($userDB->NOD_USU_CONFIGURACION, true);
            $users[$userDB->NOD_USU_ID] = $config['INSTALACION_ID'];
        }

        return $users;
    }

    function getNotification($idNotification)
    {
        $tokDB = DB::connection('reportes');
        return $tokDB->table('dat_notificacion')
        ->join('dat_campush', 'dat_notificacion.NOT_ID', '=', 'dat_campush.CAMP_NOT_ID')
        ->select(['NOT_ID', 'NOT_TITULO', 'NOT_CUERPO', 'NOT_ACCION', 'NOT_TIPO'])
        ->where('CAMP_ID', $idNotification)
        ->first();
    }

    function getDevices($users)
    {
        dd($users);
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

    function sendTestNotification($device, $notification, $type)
    {
        $users = array_keys($device);
        $devices = array_values($device);

        //Obtener el tipo
        $firebase = $this->initService();
        if($type == 'informativa')
            $message = $this->getMessageInfo($notification);
        else
            $message = $this->getMessageCoupon($notification);

        $result = $firebase->sendMulticast($message, $devices);
        $success = $result->successes()->count();
        if($success)
        {
            Log::info('Se envió la notificacion de prueba correctamente');
            //Guardar en dat_notificacion usuario
            $this->saveUsersNotification($users, $notification->NOT_ID);
        }
        else
        {
            Log::error('Ocurrió un error en el envió de la notificacion de prueba');
        }
    }

    function saveUsersNotification($users, $notification)
    {
        $tokDB = DB::connection('tokencash_campanas');
        $date = date('Y-m-d H:i:s');
        foreach($users as $user)
        {
            try
            {
                $tokDB->table('dat_notificacion_usuario')
                ->insert([
                    'NOT_USU_TS'  => $date,
                    'NOT_USU_UTS' => $date,
                    'NOT_USU_NOTIFICACION_ID' => $notification,
                    'NOT_USU_USUARIO_ID' => $user,
                    'NOT_USU_ESTADO' => '0'
                ]);
                Log::info('Se guardo el usuario en la tabla de dat_notificacion_usuario');
            }
            catch (\Throwable $th)
            {
                Log::error('Error al guardar usuario en la tabla de dat_notificacion_usuario');
            }

        }
    }

    function sendNotification($users, $notification, $type)
    {

        $firebase = $this->initService();
        if($type == 'informativa')
            $message = $this->getMessageInfo($notification);
        else
            $message = $this->getMessageCoupon($notification);

        //Obtener identificador firebase de cada dispositivo y su SO
        $devices = $this->getDevices($users);

        //Obtener numero de dispositivos android e ios
        dd($devices);

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
