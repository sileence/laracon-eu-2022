<?php

namespace Tests\Feature;

use App\Models\Product;
use App\View\Components\FeaturedProducts;
use Tests\TestCase;

class FeaturedProductsComponentTest extends TestCase
{
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

        $this->component(FeaturedProducts::class)
            ->assertSeeText('Featured product with LTV 75%')
            ->assertDontSeeText('Normal product with LTV 60%');
    }
}
