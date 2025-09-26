<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    Product::insert([
      ['nome'=>'Chips','preco'=>2.50,'categoria'=>'Snacks','created_at'=>now(),'updated_at'=>now()],
      ['nome'=>'Refrigerante','preco'=>1.75,'categoria'=>'Bebidas','created_at'=>now(),'updated_at'=>now()],
      ['nome'=>'Barra de Cereal','preco'=>3.00,'categoria'=>'Saudável','created_at'=>now(),'updated_at'=>now()],
    ]);
  }
}
