<?php

declare(strict_types=1);

namespace App\Dto;

class LtvCalculation
{
    public function __construct(
        public readonly float $propertyValue,
        public readonly float $depositAmount,
        public readonly float $netLoan,
        public readonly float $ltv,
    )
    {
    }
}
