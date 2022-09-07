<?php

namespace Tests\Unit\Services;

use App\Dto\LtvCalculation;
use App\Models\Product;
use App\Services\CalculateLtv;
use App\Services\DetermineSuitability;
use Generator;
use Tests\TestCase;
use Mockery as m;

class DetermineSuitabilityTest extends TestCase
{
    private CalculateLtv $ltvCalculator;
    private DetermineSuitability $suitability;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ltvCalculator = m::mock(CalculateLtv::class);

        $this->suitability = new DetermineSuitability($this->ltvCalculator);
    }

    /**
     * @test
     * @dataProvider providesSuitabilityCalculations
     */
    function determines_the_suitability_of_a_product(
        Product $product,
        float $propertyValue,
        float $depositAmount,
        LtvCalculation $ltvCalculation,
        bool $expectedSuitability,
    ) {
        $this->ltvCalculator
            ->expects('calculate')
            ->with($propertyValue, $depositAmount)
            ->andReturns($ltvCalculation);

        $result = $this->suitability->determine($product, $propertyValue, $depositAmount);

        self::assertSame($expectedSuitability, $result);
    }

    public function providesSuitabilityCalculations(): Generator
    {
        yield 'Suitable product: requested loan is 60% == max LTV of the product' => [
            'product' => new Product([
                'max_ltv' => 60,
            ]),
            'propertyValue' => 100000,
            'depositAmount' => 40000,
            'ltvCalculation' => new LtvCalculation(
                propertyValue: 100000,
                depositAmount: 40000,
                netLoan: 60000,
                ltv: 60,
            ),
            'expectedSuitability' => true,
        ];

        yield 'Unsuitable product: requested loan is 71% > max LTV of the product' => [
            'product' => new Product([
                'max_ltv' => 70,
            ]),
            'propertyValue' => 100000,
            'depositAmount' => 29000,
            'ltvCalculation' => new LtvCalculation(
                propertyValue: 100000,
                depositAmount: 29000,
                netLoan: 71000,
                ltv: 71,
            ),
            'expectedSuitability' => false,
        ];

        yield 'Unsuitable product: net loan is greater than the property value' => [
            'product' => new Product([
                'max_ltv' => 80,
            ]),
            'propertyValue' => 500000,
            'depositAmount' => 100000,
            'ltvCalculation' => new LtvCalculation(
                propertyValue: 500000,
                depositAmount: 100000,
                netLoan: 500001,
                ltv: 80,
            ),
            'expectedSuitability' => false,
        ];
    }
}
