<?php

namespace App\Listeners;

use App\Events\CampaignCreate;
use App\Traits\Notifications\Notifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewCampaignNotification
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
     * @param  CampaignCreate  $event
     * @return void
     */
    public function handle(CampaignCreate $event)
    {
        //Obtener usuarios tokencash
        $users = $this->getTokencashNotificationUsers();
        //Obtener datos de la campaña y notificacion
        $notification = $this->getNotification($event->notification);

        //Enviar la notificacion
        $this->sendNotificationAlert($users, $notification);
    }
}
