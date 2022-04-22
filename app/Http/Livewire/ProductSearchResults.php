<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Services\CalculateLtv;
use Livewire\Component;

class ProductSearchResults extends Component
{
    protected $listeners = ['searchProducts'];

    public $propertyValue;

    public $depositAmount;

    private CalculateLtv $calculateLtv;

    public function boot(CalculateLtv $calculateLtv)
    {
        $this->calculateLtv = $calculateLtv;
    }

    public function searchProducts($formData)
    {
        [$this->propertyValue, $this->depositAmount] = $formData;
    }

    public function render()
    {
        $searchProducts = $this->propertyValue && $this->depositAmount;

        if ($searchProducts) {
            $ltvCalculation = $this->calculateLtv->calculate($this->propertyValue, $this->depositAmount);

            $products = Product::query()
                ->where('max_ltv', '>=', $ltvCalculation->ltv)
                ->orderBy('max_ltv')
                ->get()
                ->each(function (Product $product) use ($ltvCalculation) {
                    $product->fee_amount = $ltvCalculation->netLoan * $product->fee / 100;
                    $product->gross_loan = $ltvCalculation->netLoan + $product->fee_amount;
                    $product->monthly_interest = $product->gross_loan * $product->interest_rate / 100 / 12;
                });
        } else {
            $ltvCalculation = null; // Good case for the Null Object Pattern?

            $products = collect();
        }

        return view('livewire.product-search-results', [
            'searchProducts' => $searchProducts,
            'ltvCalculation' => $ltvCalculation,
            'products' => $products,
        ]);
    }
}
