<?php

namespace App\Listeners;

use App\Events\CampaignTest;
use App\Traits\Notifications\Notifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTestCampaignNotification
{
    use Notifications;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CampaignTest  $event
     * @return void
     */
    public function handle(CampaignTest $event)
    {
        //Obtener usuarios tokencash
        $user = $this->getTokencashNotificationUser($event->number);
        //Obtener datos de la campaña y notificacion
        $notification = $this->getNotification($event->notification);

        //Enviar la notificacion
        $this->sendNotification($user, $notification, $notification->NOT_TIPO);
    }
}
