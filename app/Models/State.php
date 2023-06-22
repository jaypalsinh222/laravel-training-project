<?php

namespace App\Models;

use App\Models\Scopes\StateDetailScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new StateDetailScope());
    }

    public function scopeName($query){
        return $query->where('name','rajasthan');
    }

//    public function scopeCities($query){
//        return $query->with('cities');
//    }

    public function country(){
        return $this->belongsTo(Country::class,'county_id','id');
    }

    public function cities(){
        return $this->hasMany(City::class);
    }

    public function capital(){
        return $this->hasOne(Capital::class);
    }

}
