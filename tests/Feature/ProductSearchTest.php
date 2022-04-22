<?php

namespace Tests\Feature;

use App\Http\Livewire\ProductSearchForm;
use App\Http\Livewire\ProductSearchResults;
use App\Models\Product;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    /** @test */
    public function loads_the_search_products_page()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSeeLivewire(ProductSearchForm::class)
            ->assertSeeLivewire(ProductSearchResults::class);
    }

    /** @test */
    public function show_featured_products()
    {
        Product::factory()->create([
            'name' => 'Featured product with LTV 75%',
            'featured' => true,
        ]);

        Product::factory()->create([
            'name' => 'Normal product with LTV 60%',
            'featured' => false,
        ]);

        $this->get('/')
            ->assertSeeText('Featured product with LTV 75%')
            ->assertDontSeeText('Normal product with LTV 60%');
    }
}
