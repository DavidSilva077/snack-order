<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'cliente' => $this->faker->name(),
            'data' => now(),
            'status' => 'pendente',
        ];
    }
}
