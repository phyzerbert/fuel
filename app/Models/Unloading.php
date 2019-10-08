<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unloading extends Model
{    
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tank(){
        return $this->belongsTo(Tank::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

}
