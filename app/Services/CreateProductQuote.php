<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\LtvCalculation;
use App\Dto\ProductQuote;
use App\Models\Product;

class CreateProductQuote
{
    public function create(Product $product, LtvCalculation $ltvCalculation): ProductQuote
    {
        $feeAmount = $ltvCalculation->netLoan * $product->fee / 100;
        $grossLoanAmount = $ltvCalculation->netLoan + $feeAmount;
        $monthlyInterest = $grossLoanAmount * $product->interest_rate / 100 / 12;

        return new ProductQuote(
            product: $product,
            feeAmount: $feeAmount,
            grossLoanAmount: $grossLoanAmount,
            monthlyInterest: $monthlyInterest,
        );
    }
}
