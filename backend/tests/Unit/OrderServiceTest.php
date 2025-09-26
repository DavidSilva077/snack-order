<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_order_and_items_and_loads_relations()
    {
        $service = new OrderService();

        $p1 = Product::factory()->create(['preco' => 7.0]);
        $p2 = Product::factory()->create(['preco' => 3.5]);

        $order = $service->create('João', [
            ['product_id' => $p1->id, 'quantidade' => 1],
            ['product_id' => $p2->id, 'quantidade' => 4],
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals('pendente', $order->status);
        $this->assertTrue($order->relationLoaded('itens'));
        $this->assertTrue($order->itens->first()->relationLoaded('product'));

        $this->assertDatabaseCount('order_items', 2);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id, 'product_id' => $p1->id,
            'quantidade' => 1, 'preco_unitario' => 7.0, 'subtotal' => 7.0,
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id, 'product_id' => $p2->id,
            'quantidade' => 4, 'preco_unitario' => 3.5, 'subtotal' => 14.0,
        ]);
    }
}
