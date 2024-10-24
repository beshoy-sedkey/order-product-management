<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\PlaceOrderRequest;
use App\Services\Repositories\OrderRepositoryInterface;
use App\Services\Repositories\PlaceOrderService;

class OrderController extends Controller
{
    protected PlaceOrderService $placeOrder;
    public function __construct(PlaceOrderService $placeOrder)
    {
        $this->placeOrder = $placeOrder;
    }
    public function placeOrder(PlaceOrderRequest $request)
    {
        $order = $this->placeOrder->placeOrder($request->validated()['products']);
        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }

        public function show(Order $order, OrderRepositoryInterface $orderRepo)
        {
            $showOrder = $orderRepo->find($order->id, 'products');
            return response()->json([
                'order' => $order,
                'products' => $order->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $product->pivot->quantity,
                    ];
                }),
            ], 200);
        }
    }
