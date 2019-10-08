<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    protected $guarded = [];

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

    public function tanks(){
        return $this->hasMany(Tank::class);
    }
    
}
