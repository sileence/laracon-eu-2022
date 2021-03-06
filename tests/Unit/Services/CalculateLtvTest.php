<?php

namespace Tests\Unit\Services;

use App\Services\CalculateLtv;
use Iterator;
use Tests\TestCase;

class CalculateLtvTest extends TestCase
{
    /**
     * @test
     * @dataProvider providesCalculations
     */
    public function calculates_the_net_loan_and_ltv(
        float $givenPropertyValue,
        float $givenDepositAmount,
        float $expectedNetLoan,
        float $expectedLtv,
    )
    {
        $calculateLtvService = new CalculateLtv;

        $ltvCalculation = $calculateLtvService->calculate($givenPropertyValue, $givenDepositAmount);

        self::assertSame($givenPropertyValue, $ltvCalculation->propertyValue);
        self::assertSame($givenDepositAmount, $ltvCalculation->depositAmount);
        self::assertSame($expectedNetLoan, $ltvCalculation->netLoan);
        self::assertSame($expectedLtv, $ltvCalculation->ltv);
    }

    private function providesCalculations(): Iterator
    {
        yield [
            'givenPropertyValue' => 100_000,
            'givenDepositAmount' => 25_000,
            'expectedNetLoan' => 75_000,
            'expectedLtv' => 75,
        ];

        yield [
            'givenPropertyValue' => 250_000,
            'givenDepositAmount' => 50_000,
            'expectedNetLoan' => 200_000,
            'expectedLtv' => 80,
        ];

        // ...
    }
}
