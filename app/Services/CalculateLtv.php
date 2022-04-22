<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\LtvCalculation;

class CalculateLtv
{
    public function calculate(float $propertyValue, float $depositAmount): LtvCalculation
    {
        $netLoan = $propertyValue - $depositAmount;
        $ltv = ($netLoan / $propertyValue) * 100;
        // ...

        return new LtvCalculation(
            propertyValue: $propertyValue,
            depositAmount: $depositAmount,
            netLoan: $netLoan,
            ltv: $ltv,
        // ...
        );
    }
}
