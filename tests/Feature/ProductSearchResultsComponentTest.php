<?php

namespace Tests\Feature;

use App\Http\Livewire\ProductSearch;
use App\Http\Livewire\ProductSearchResults;
use App\Models\Product;
use Livewire\Livewire;
use Tests\TestCase;

class ProductSearchResultsComponentTest extends TestCase
{
    /** @test */
    public function calculates_ltv_and_loan_amount()
    {
        Livewire::test(ProductSearchResults::class)
            ->emit('searchProducts', ['100000', '20000'])
            ->assertSeeInOrder([
                'LTV', '80%', 'Loan amount', '£80,000'
            ]);
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
            'max_ltv' => 81,
            'featured' => false,
        ]);

        Livewire::test(ProductSearchResults::class)
            ->emit('searchProducts', ['100000', '20000'])
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

        Livewire::test(ProductSearchResults::class)
            ->emit('searchProducts', ['200000', '50000'])
            ->assertSee('Product with LTV 75%')
            ->assertSee('Product with LTV 76%')
            ->assertDontSee('Product with LTV 73%')
            ->assertDontSee('Product with LTV 74%');
    }
}
