<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\DetermineSuitability;
use Generator;
use Tests\TestCase;

class DetermineSuitabilityTest extends TestCase
{
    protected DetermineSuitability $suitability;

    protected function setUp(): void
    {
        parent::setUp();

        $this->suitability = new DetermineSuitability();
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
    }
}
