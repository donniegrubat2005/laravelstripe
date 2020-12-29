<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'customer',
        'customer_email',
        'description',
        'description1',
        'currency',
        'invoice_number',
        'receipt_number',
        'discount',
        'price',
        'price1',
        'amount',
        'amount1',
        'subtotal',
        'total',
        'amount_due',
        'paid',
        'url_link'
    ];
}
