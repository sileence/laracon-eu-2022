<?php

namespace Tests\Feature;

use App\Http\Livewire\ProductSearch;
use App\Models\Product;
use Livewire\Livewire;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    /** @test */
    public function loads_the_search_products_page()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSeeLivewire(ProductSearch::class);
    }

    /** @test */
    public function shows_featured_products()
    {
        Product::factory()->create([
            'name' => 'Featured product with LTV 75%',
            'featured' => true,
        ]);

        Product::factory()->create([
            'name' => 'Normal product with LTV 60%',
            'featured' => false,
        ]);

        Livewire::test(ProductSearch::class)
            ->assertSeeText('Featured product with LTV 75%')
            ->assertDontSeeText('Normal product with LTV 60%');
    }
}
