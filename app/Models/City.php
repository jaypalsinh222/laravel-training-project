<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function scopeState($query){
        return $query->with('state');
    }

    public function state(){
        return $this->belongsTo(State::class,'state_id','id');//->with('country');
    }

     public function country(){
         return $this->hasOneThrough(Country::class,State::class,'county_id','id','id','id');
     }



}
