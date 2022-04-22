<?php

namespace Tests\Unit\Services;

use App\Dto\LtvCalculation;
use App\Dto\ProductQuote;
use App\Models\Product;
use App\Services\CreateProductQuote;
use Iterator;
use Tests\TestCase;

class CreateProductQuoteTest extends TestCase
{
    /**
     * @test
     * @dataProvider providesProductsAndCalculations
     */
    public function creates_a_quote_for_a_product(
        LtvCalculation $givenLtvCalculation,
        Product $givenProduct,
        ProductQuote $expectedQuote
    )
    {
        $createProductQuote = new CreateProductQuote();

        $actualQuote = $createProductQuote->create($givenProduct, $givenLtvCalculation);

        $this->assertProductQuote($expectedQuote, $actualQuote);
    }

    private function providesProductsAndCalculations(): Iterator
    {
        yield [
            'givenLtvCalculation' => new LtvCalculation(
                propertyValue: 100_000,
                depositAmount: 25_000,
                netLoan: 75_000,
                ltv: 75,
            ),
            'givenProduct' => $product1 = new Product([
                'fee' => 3.5,
                'interest_rate' => 1.75,
            ]),
            'expectedProductQuote' => new ProductQuote(
                product: $product1,
                feeAmount: 2_625.00,
                grossLoanAmount: 77_625.00,
                monthlyInterest: 113.203125,
            )
        ];

        yield [
            'givenLtvCalculation' => new LtvCalculation(
                propertyValue: 250_000,
                depositAmount: 50_000,
                netLoan: 200_000,
                ltv: 80,
            ),
            'givenProduct' => $product2 = new Product([
                'fee' => 4,
                'interest_rate' => 3,
            ]),
            'expectedProductQuote' => new ProductQuote(
                product: $product2,
                feeAmount: 8_000.00,
                grossLoanAmount: 208_000.00,
                monthlyInterest: 520,
            )
        ];
    }
}
