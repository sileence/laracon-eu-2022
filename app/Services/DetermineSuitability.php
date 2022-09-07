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

        if ($ltvCalculation->netLoan > $propertyValue) {
            return false;
        }

        if ($product->max_ltv < $ltvCalculation->ltv) {
            return false;
        }

        return true;
    }
}
