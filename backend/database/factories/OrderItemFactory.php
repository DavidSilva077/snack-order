<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $product = Product::factory()->create();
        $qty = $this->faker->numberBetween(1, 5);
        $unit = $product->preco;

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'quantidade' => $qty,
            'preco_unitario' => $unit,
            'subtotal' => $unit * $qty,
        ];
    }
}
