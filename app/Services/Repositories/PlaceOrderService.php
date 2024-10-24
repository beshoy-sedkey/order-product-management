<?php

namespace App\Services\Repositories;

use App\Models\Order;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PlaceOrderService
{
    protected ProductRepositoryInterface $product;
    protected OrderRepositoryInterface $order;
    protected $user ;

    public function __construct(ProductRepositoryInterface $product, OrderRepositoryInterface $order)
    {
        $this->product = $product;
        $this->order = $order;
        $this->user = Auth::user();

    }

    public function placeOrder($productsData)
    {
        return DB::transaction(function () use ( $productsData) {
            $totalPrice = $this->calculateTotalPrice($productsData);
            $order = $this->order->create([
                'user_id' => $this->user->id,
                'total_price' => $totalPrice,
            ]);

            $this->attachProductsToOrder($order, $productsData);
            event(new OrderPlaced($order));


            return $order;
        });
    }

    protected function calculateTotalPrice($productsData)
    {
        $totalPrice = 0;
        foreach ($productsData as $productOrder) {
            $product = $this->product->find($productOrder['id']);
            $totalPrice += $product->price * $productOrder['quantity'];
        }
        return $totalPrice;
    }

    protected function attachProductsToOrder(Order $order, $productsData)
    {
        foreach ($productsData as $productOrder) {
            $product = $this->product->find($productOrder['id']);
            $order->products()->attach($product->id, ['quantity' => $productOrder['quantity']]);
            $product->decrement('stock_quantity', $productOrder['quantity']);
        }
    }
}
