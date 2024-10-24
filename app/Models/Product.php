<?php

namespace App\Models;

use App\Services\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'price', 'stock_quantity'];

    public function orders()
    {
        return $this->belongsToMany(Order::class , 'orders_products')->withPivot('quantity');
    }

    public function decrementStock($quantity)
    {
        $this->decrement('stock_quantity', $quantity);
    }
}
