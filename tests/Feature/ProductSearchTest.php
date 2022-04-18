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

        Livewire::test(ProductSearch::class)
            ->assertSeeText('Featured product with LTV 75%')
            ->assertDontSeeText('Normal product with LTV 60%');
    }

    /** @test */
    public function calculates_ltv_and_loan_amount()
    {
        Livewire::test(ProductSearch::class)
            ->set('propertyValue', '100000')
            ->set('depositAmount', '20000')
            ->assertSee('LTV: 80%')
            ->assertSee('Loan amount: £80,000');
    }

    /** @test */
    public function shows_available_products_with_ltv_greater_or_equal_than_80()
    {
        Product::factory()->create([
            'name' => 'Product with LTV 80%',
            'max_ltv' => 80,
            'featured' => false,
        ]);

        Product::factory()->create([
            'name' => 'Product with LTV 79%',
            'max_ltv' => 79,
            'featured' => false,
        ]);

        Product::factory()->create([
            'name' => 'Product with LTV 81%',
            'max_ltv' => 91,
            'featured' => false,
        ]);

        Livewire::test(ProductSearch::class)
            ->set('propertyValue', '100000')
            ->set('depositAmount', '20000')
            ->assertSee('Product with LTV 80%')
            ->assertSee('Product with LTV 81%')
            ->assertDontSee('Product with LTV 79%');
    }

    /** @test */
    public function shows_available_products_with_ltv_greater_or_equal_than_75()
    {
        Product::factory()->create([
            'name' => 'Product with LTV 75%',
            'max_ltv' => 75,
            'featured' => false,
        ]);

        Product::factory()->create([
            'name' => 'Product with LTV 73%',
            'max_ltv' => 73,
            'featured' => false,
        ]);

        Product::factory()->create([
            'name' => 'Product with LTV 76%',
            'max_ltv' => 76,
            'featured' => false,
        ]);

        Product::factory()->create([
            'name' => 'Product with LTV 74%',
            'max_ltv' => 74,
            'featured' => false,
        ]);

        Livewire::test(ProductSearch::class)
            ->set('propertyValue', '200000')
            ->set('depositAmount', '50000')
            ->assertSee('Product with LTV 75%')
            ->assertSee('Product with LTV 76%')
            ->assertDontSee('Product with LTV 73%')
            ->assertDontSee('Product with LTV 74%');
    }
}
