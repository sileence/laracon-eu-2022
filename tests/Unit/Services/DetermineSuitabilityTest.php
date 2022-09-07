<?php

namespace Tests\Unit\Services;

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
        bool $expectedSuitability,
    ) {
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
            'expectedSuitability' => true,
        ];

        yield 'Unsuitable product: requested loan is 71% > max LTV of the product' => [
            'product' => new Product([
                'max_ltv' => 70,
            ]),
            'propertyValue' => 100000,
            'depositAmount' => 29000,
            'expectedSuitability' => false,
        ];
    }
}
