<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = [];

    public function fuel(){
        return $this->belongsTo(Fuel::class);
    }

    public function unloadings(){
        return $this->hasMany(Unloading::class);
    }

    public function type(){
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function driver(){
        return $this->belongsTo(Driver::class);
    }
}
