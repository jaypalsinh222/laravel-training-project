<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id', 'subtotal', 'total_cgst', 'total_sgst', 'totalamount', 'discount', 'grandtotal'
    ];

    public function invoiceItems(){
        return $this->hasMany(Invoiceitem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
