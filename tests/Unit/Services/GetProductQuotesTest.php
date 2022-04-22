<?php

namespace Tests\Unit\Services;

use App\Dto\LtvCalculation;
use App\Dto\ProductQuote;
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

        Product::factory()->create([
            'name' => 'Product with LTV 73%',
            'max_ltv' => 73,
            'featured' => false,
        ]);

        $productWithLtv76 = Product::factory()->create([
            'max_ltv' => 76,
            'fee' => 3,
            'interest_rate' => 2,
        ]);

        Product::factory()->create([
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

        $expectedQuote = new ProductQuote(
            product: $productWithLtv76,
            feeAmount: 2250.0,
            grossLoanAmount: 77250.0,
            monthlyInterest: 128.75,
        );
        $this->assertProductQuote($expectedQuote, $productQuotes->pop());

        $expectedQuote = new ProductQuote(
            product: $productWithLtv75,
            feeAmount: 1500.0,
            grossLoanAmount: 76500.0,
            monthlyInterest: 95.625,
        );
        $this->assertProductQuote($expectedQuote, $productQuotes->pop());
    }
}
