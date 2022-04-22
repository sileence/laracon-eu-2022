<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\LtvCalculation;
use App\Dto\ProductQuote;
use App\Models\Product;
use Illuminate\Support\Collection;

class GetProductQuotes
{
    public function __construct(private CreateProductQuote $createProductQuote)
    {
    }

    /**
     * @param LtvCalculation $ltvCalculation
     * @return Collection<int, ProductQuote>
     */
    public function get(LtvCalculation $ltvCalculation): Collection
    {
        return Product::query()
            ->where('max_ltv', '>=', $ltvCalculation->ltv)
            ->orderBy('max_ltv')
            ->get()
            ->map(fn(Product $product) => $this->createProductQuote->create($product, $ltvCalculation));
    }
}
