<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_products_ordered_desc_by_id()
    {
        Product::factory()->create(['id' => 1, 'nome' => 'A']);
        Product::factory()->create(['id' => 2, 'nome' => 'B']);

        $res = $this->getJson('/api/products')
            ->assertOk()
            ->json();

        $this->assertCount(2, $res);
        $this->assertSame(2, $res[0]['id']);
        $this->assertSame(1, $res[1]['id']);
    }

    /** @test */
    public function it_creates_a_product()
    {
        $payload = ['nome' => 'Pizza', 'preco' => 39.9, 'categoria' => 'Comida'];

        $this->postJson('/api/products', $payload)
            ->assertCreated()
            ->assertJsonFragment($payload);

        $this->assertDatabaseHas('products', $payload);
    }

    /** @test */
    public function it_shows_a_product()
    {
        $p = Product::factory()->create();

        $this->getJson("/api/products/{$p->id}")
            ->assertOk()
            ->assertJsonFragment(['id' => $p->id, 'nome' => $p->nome]);
    }

    /** @test */
    public function it_updates_a_product()
    {
        $p = Product::factory()->create(['nome' => 'Velho']);

        $this->putJson("/api/products/{$p->id}", ['nome' => 'Novo'])
            ->assertOk()
            ->assertJsonFragment(['nome' => 'Novo']);

        $this->assertDatabaseHas('products', ['id' => $p->id, 'nome' => 'Novo']);
    }

    /** @test */
    public function it_deletes_a_product()
    {
        $p = Product::factory()->create();

        $this->deleteJson("/api/products/{$p->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('products', ['id' => $p->id]);
    }

    /** @test */
    public function it_may_filter_by_search_when_driver_supports_ilike()
    {
        $driver = Config::get('database.default');
        $connection = Config::get("database.connections.$driver.driver");
        if ($connection !== 'pgsql') {
            $this->markTestSkipped('ILIKE é específico do Postgres; pulando em drivers não-Postgres.');
        }

        Product::factory()->create(['nome' => 'Coca-Cola', 'categoria' => 'Bebida']);
        Product::factory()->create(['nome' => 'Café', 'categoria' => 'Bebida']);

        $this->getJson('/api/products?search=coca')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['nome' => 'Coca-Cola']);
    }
}
