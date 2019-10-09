<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $guarded = [];

    public function fuel(){
        return $this->belongsTo(Fuel::class);
    }

    public function unloadings(){
        return $this->hasMany(Unloading::class);
    }
    
    public function fillings(){
        return $this->hasMany(Filling::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }
}
