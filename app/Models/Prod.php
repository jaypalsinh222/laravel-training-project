<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prod extends Model
{
    private $name, $price;
    use HasFactory;

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_product');
    }

    //---laravel 9.0
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => strtolower($value),
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => $value
        );
    }

    //---laravel 8.0
//    public function getNameAttribute($value)
//    {
//        return strtolower($value);
//    }


}
