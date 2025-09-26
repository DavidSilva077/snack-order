<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
  public function create(string $cliente, array $itens): Order
  {
    return DB::transaction(function () use ($cliente, $itens) {
      $order = Order::create([
        'cliente' => $cliente,
        'data' => now(),
        'status' => 'pendente',
      ]);

      foreach ($itens as $i) {
        $product = Product::findOrFail($i['product_id']);
        $qty = (int) $i['quantidade'];
        $unit = $product->preco;

        OrderItem::create([
          'order_id' => $order->id,
          'product_id' => $product->id,
          'quantidade' => $qty,
          'preco_unitario' => $unit,
          'subtotal' => $unit * $qty,
        ]);
      }

      return $order->load(['itens.product']);
    });
  }
}
