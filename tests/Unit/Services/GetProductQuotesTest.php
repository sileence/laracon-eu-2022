<?php

namespace Tests\Unit\Services;

use App\Dto\LtvCalculation;
use App\Models\Product;
use App\Services\CreateProductQuote;
use App\Services\GetProductQuotes;
use Tests\TestCase;

class GetProductQuotesTest extends TestCase
{
    /** @test */
    public function get_product_quotes_with_ltv_greater_or_equal_than_75()
    {
        $productWithLtv75 = Product::factory()->create([
            'max_ltv' => 75,
            'fee' => 2,
            'interest_rate' => 1.5,
        ]);

        $productWithLtv73 = Product::factory()->create([
            'name' => 'Product with LTV 73%',
            'max_ltv' => 73,
            'featured' => false,
        ]);

        $productWithLtv76 = Product::factory()->create([
            'max_ltv' => 76,
            'fee' => 3,
            'interest_rate' => 2,
        ]);

        $productWithLtv74 = Product::factory()->create([
            'max_ltv' => 74,
        ]);

        $getProductQuotes = new GetProductQuotes(new CreateProductQuote);

        $productQuotes = $getProductQuotes->get(new LtvCalculation(
            propertyValue: 100_000,
            depositAmount: 25_000,
            netLoan: 75_000,
            ltv: 75.0,
        ));

        self::assertCount(2, $productQuotes);

        tap($productQuotes->pop(), function (Product $product) use ($productWithLtv76) {
            self::assertTrue($product->is($productWithLtv76));
            self::assertSame(2250.0, $product->fee_amount);
            self::assertSame(77250.0, $product->gross_loan);
            self::assertSame(128.75, $product->monthly_interest);
        });

        tap($productQuotes->pop(), function (Product $product) use ($productWithLtv75) {
            self::assertTrue($product->is($productWithLtv75));
            self::assertSame(1500.0, $product->fee_amount);
            self::assertSame(76500.0, $product->gross_loan);
            self::assertSame(95.625, $product->monthly_interest);
        });
    }
}
