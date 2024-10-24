<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    public function test_authenticated_user_can_create_order()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product1 = Product::factory()->create(['stock_quantity' => 10]);
        $product2 = Product::factory()->create(['stock_quantity' => 5]);

        $orderData = [
            'products' => [
                ['id' => $product1->id, 'quantity' => 2],
                ['id' => $product2->id, 'quantity' => 3],
            ],
        ];

        $response = $this->postJson('/api/orders', $orderData);
        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);

        $order = Order::find(1);
        $this->assertEquals(2, $order->products()->where('product_id', $product1->id)->first()->pivot->quantity);
        $this->assertEquals(3, $order->products()->where('product_id', $product2->id)->first()->pivot->quantity);

        $this->assertEquals(8, Product::find($product1->id)->stock_quantity);
        $this->assertEquals(2, Product::find($product2->id)->stock_quantity);



    }


    public function test_unauthenticated_user_cannot_create_order()
    {
        $orderData = ['products' => []];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(401);
    }

    public function test_get_order_details()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/orders/'.$order->id);


        $response->assertStatus(200);
        $response->assertJsonStructure([
            'order' => [
                'id',
                'user_id',
                'created_at',
                'updated_at',
            ],
            'products' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'stock_quantity',
                ],
            ],
        ]);


    }


}
