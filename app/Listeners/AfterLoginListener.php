<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class AfterLoginListener
{
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => request()->getClientIp()
        ]);

        $role = $event->user->roles()->first();
        if($role)
        {
            request()->session()->put('user_role', $role->id);
        }
    }
}
