<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Product;

class ProductQuote
{
    public function __construct(
        public readonly Product $product,
        public readonly float $feeAmount,
        public readonly float $grossLoanAmount,
        public readonly float $monthlyInterest,
    )
    {
    }
}
