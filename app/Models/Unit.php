<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function unloadings(){
        return $this->hasMany(Unloading::class);
    }

    public function fillings(){
        return $this->hasMany(Filling::class);
    }

    public function tanks(){
        return $this->hasMany(Tank::class);
    }
}
