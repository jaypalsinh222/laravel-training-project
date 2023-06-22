<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoiceitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'product_id', 'row_key', 'quantity', 'price', 'totalsubtotal', 'cgst', 'sgst', 'totalamount',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
