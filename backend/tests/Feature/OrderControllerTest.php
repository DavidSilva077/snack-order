<?php

namespace Tests\Feature;

use App\Jobs\AdvanceOrderStatusJob;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_order_and_dispatches_delayed_job()
    {
        Queue::fake();

        $p1 = Product::factory()->create(['preco' => 10.0]);
        $p2 = Product::factory()->create(['preco' => 5.5]);

        $payload = [
            'cliente' => 'Maria',
            'itens' => [
                ['product_id' => $p1->id, 'quantidade' => 2],
                ['product_id' => $p2->id, 'quantidade' => 3],
            ],
        ];

        $res = $this->postJson('/api/orders', $payload)
            ->assertCreated()
            ->json();

        $orderId = $res['id'] ?? null;
        $this->assertNotNull($orderId);

        $this->assertDatabaseHas('orders', ['id' => $orderId, 'cliente' => 'Maria', 'status' => 'pendente']);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $orderId, 'product_id' => $p1->id,
            'quantidade' => 2, 'preco_unitario' => 10.0, 'subtotal' => 20.0,
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $orderId, 'product_id' => $p2->id,
            'quantidade' => 3, 'preco_unitario' => 5.5, 'subtotal' => 16.5,
        ]);

        Queue::assertPushed(AdvanceOrderStatusJob::class, function ($job) use ($orderId) {
            return $job->orderId === $orderId && $job->delay !== null;
        });
    }

    /** @test */
    public function it_shows_an_order_with_items_and_products()
    {
        $order = Order::factory()->create(['status' => 'pendente']);
        $p = Product::factory()->create(['preco' => 12.3]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $p->id,
            'quantidade' => 2,
            'preco_unitario' => 12.3,
            'subtotal' => 24.6,
        ]);

        $this->getJson("/api/orders/{$order->id}")
            ->assertOk()
            ->assertJsonFragment(['id' => $order->id])
            ->assertJsonFragment(['product_id' => $p->id]);
    }

    /** @test */
    public function it_updates_order_status_via_patch()
    {
        $order = Order::factory()->create(['status' => 'pendente']);

        $this->patchJson("/api/orders/{$order->id}/status", ['status' => 'em_preparacao'])
            ->assertOk()
            ->assertJsonFragment(['status' => 'em_preparacao']);

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'em_preparacao']);
    }

    /** @test */
    public function it_validates_status_input()
    {
        $order = Order::factory()->create(['status' => 'pendente']);

        $this->patchJson("/api/orders/{$order->id}/status", ['status' => 'invalido'])
            ->assertStatus(422);
    }

    /** @test */
    public function it_validates_order_store_payload()
    {
        $this->postJson('/api/orders', [
            'cliente' => '', 
            'itens' => [],
        ])->assertStatus(422);
    }
}
