<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'reportes';
    protected $table = 'dat_notificacion';
    protected $primaryKey = 'NOT_ID';

    protected $hidden = ['NOT_UID', 'NOT_SID', 'NOT_UTS', 'NOT_UUID', 'NOT_USID'];

    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'CAMP_NOT_ID', 'NOT_ID');
    }
}
