<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = strtoupper($value);
    }
}

