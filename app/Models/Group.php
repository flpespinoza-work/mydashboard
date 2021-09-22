<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'contact'];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
              ->where('name', 'like', '%' . $search . '%');
    }

    //Guardar el nombre con mayusculas
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = strtoupper($value);
    }
}
