<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function can_create_a_product()
    {
        $product = Product::create([
            'name' => 'Product with 60% LTV',
            'max_ltv' => 60,
            'fee' => 3,
            'interest_rate' => 1,
            'featured' => true,
        ]);

        self::assertSame('Product with 60% LTV', $product->name);
        self::assertSame(60, $product->max_ltv);
        self::assertSame(3, $product->fee);
        self::assertSame(1, $product->interest_rate);
        self::assertTrue($product->featured);
    }
}
