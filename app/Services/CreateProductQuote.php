<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\QuotableProduct;
use App\Dto\LtvCalculation;
use App\Dto\ProductQuote;

class CreateProductQuote
{
    public function create(QuotableProduct $product, LtvCalculation $ltvCalculation): ProductQuote
    {
        $feeAmount = $ltvCalculation->netLoan * $product->getFee() / 100;
        $grossLoanAmount = $ltvCalculation->netLoan + $feeAmount;
        $monthlyInterest = $grossLoanAmount * $product->getInterestRate() / 100 / 12;

        return new ProductQuote(
            product: $product,
            feeAmount: $feeAmount,
            grossLoanAmount: $grossLoanAmount,
            monthlyInterest: $monthlyInterest,
        );
    }
}
