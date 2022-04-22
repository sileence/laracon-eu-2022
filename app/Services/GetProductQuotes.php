<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\LtvCalculation;
use App\Models\Product;
use Illuminate\Support\Collection;

class GetProductQuotes
{
    public function __construct(private CreateProductQuote $createProductQuote)
    {
    }

    public function get(LtvCalculation $ltvCalculation): Collection
    {
        return Product::query()
            ->where('max_ltv', '>=', $ltvCalculation->ltv)
            ->orderBy('max_ltv')
            ->get()
            ->each(function (Product $product) use ($ltvCalculation) {
                $productQuote = $this->createProductQuote->create($product, $ltvCalculation);

                $product->fee_amount = $productQuote->feeAmount;
                $product->gross_loan = $productQuote->grossLoanAmount;
                $product->monthly_interest = $productQuote->monthlyInterest;
            });
    }
}
