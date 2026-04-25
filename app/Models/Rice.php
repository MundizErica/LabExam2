<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rice extends Model
{
    use HasFactory;

    protected $table = 'rices'; // ← add this line

    protected $fillable = ['name', 'price_per_kg', 'stock_quantity_kg', 'description'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}