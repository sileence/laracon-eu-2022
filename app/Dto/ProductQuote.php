<?php

declare(strict_types=1);

namespace App\Dto;

use App\Contracts\QuotableProduct;

class ProductQuote
{
    public function __construct(
        public readonly QuotableProduct $product,
        public readonly float $feeAmount,
        public readonly float $grossLoanAmount,
        public readonly float $monthlyInterest,
    )
    {
    }
}
