<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filling extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tank(){
        return $this->belongsTo(Tank::class);
    }
    
}
