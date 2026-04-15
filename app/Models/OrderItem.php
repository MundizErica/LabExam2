<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'rice_id',
        'quantity_kg',
        'price_per_kg',
        'subtotal'
    ];

    public function rice()
    {
        return $this->belongsTo(Rice::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
