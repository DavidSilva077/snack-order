<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->words(2, true),
            'preco' => $this->faker->randomFloat(2, 1, 200),
            'categoria' => $this->faker->randomElement(['Comida','Bebida','Sobremesa']),
        ];
    }
}
