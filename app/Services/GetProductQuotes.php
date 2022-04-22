<?php

namespace App\Services;

use App\Dto\LtvCalculation;
use App\Models\Product;
use Illuminate\Support\Collection;

class GetProductQuotes
{
    public function get(LtvCalculation $ltvCalculation): Collection
    {
        return Product::query()
            ->where('max_ltv', '>=', $ltvCalculation->ltv)
            ->orderBy('max_ltv')
            ->get()
            ->each(function (Product $product) use ($ltvCalculation) {
                $product->fee_amount = $ltvCalculation->netLoan * $product->fee / 100;
                $product->gross_loan = $ltvCalculation->netLoan + $product->fee_amount;
                $product->monthly_interest = $product->gross_loan * $product->interest_rate / 100 / 12;
            });
    }
}
