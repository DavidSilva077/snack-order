<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AdvanceOrderStatusJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct(public int $orderId) {}

  public function handle(): void
  {
    $order = Order::find($this->orderId);
    if (!$order) return;

    if ($order->status === 'pendente') {
      $order->update(['status' => 'em_preparacao']);
    }
  }
}
