<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    //Guardar el nombre con mayusculas
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = strtoupper($value);
    }
}
