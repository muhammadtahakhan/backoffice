<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    use HasFactory;
     protected $fillable = [
        'sale_id',
        'amount',
        'payment_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
