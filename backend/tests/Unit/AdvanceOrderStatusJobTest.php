<?php

namespace Tests\Unit;

use App\Jobs\AdvanceOrderStatusJob;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvanceOrderStatusJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_advances_from_pendente_to_em_preparacao()
    {
        $order = Order::factory()->create(['status' => 'pendente']);

        (new AdvanceOrderStatusJob($order->id))->handle();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'em_preparacao',
        ]);
    }

    /** @test */
    public function it_does_nothing_if_order_not_found_or_status_not_pendente()
    {
        (new AdvanceOrderStatusJob(9999))->handle();
        $this->assertTrue(true);

        $order = Order::factory()->create(['status' => 'pronto']);
        (new AdvanceOrderStatusJob($order->id))->handle();

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'pronto']);
    }
}
