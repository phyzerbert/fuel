<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $guarded = [];

    public function fuel(){
        return $this->belongsTo(Fuel::class);
    }
}
