<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class);
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

    public static function getStoresByGroup($group)
    {
        if($group == 1)
        {
            return Store::orderBy('name')->get();
        }

        return Store::where('group_id', $group)
        ->orderBy('name')
        ->get();
    }

}
