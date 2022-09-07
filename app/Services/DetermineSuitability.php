<?php

namespace App\Services;

use App\Models\Product;

class DetermineSuitability
{
    public function __construct(private CalculateLtv $ltvCalculator)
    {
    }

    public function determine(Product $product, float $propertyValue, float $depositAmount): bool
    {
        $ltvCalculation = $this->ltvCalculator->calculate($propertyValue, $depositAmount);

        return $product->max_ltv >= $ltvCalculation->ltv;
    }
}
