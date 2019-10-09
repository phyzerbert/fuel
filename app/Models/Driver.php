<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $guarded = [];

    public function unloadings(){
        return $this->hasMany(Unloading::class);
    }
    
    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }
}
