<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $connection = 'reportes';
    protected $table = 'dat_campush';
    protected $primaryKey = 'CAMP_ID';

    protected $hidden = ['CAMP_UID', 'CAMP_SID', 'CAMP_UTS', 'CAMP_UUID', 'CAMP_USID'];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'CAMP_NOT_ID', 'NOT_ID');
    }
}
