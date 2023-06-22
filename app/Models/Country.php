<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function states(){
        return $this->hasMany(State::class,'county_id','id');
    }

    public function cities(){
        return $this->hasManyThrough(City::class,State::class,'county_id','state_id','id','id');
    }

    public function city(){
        return $this->hasOneThrough(City::class,State::class,'county_id','state_id','id','id');
    }

}
