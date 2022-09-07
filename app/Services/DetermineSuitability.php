<?php

namespace App\Services;

use App\Models\Product;

class DetermineSuitability
{
    public function determine(Product $product, float $propertyValue, float $depositAmount): bool
    {
        return true;
    }
}
