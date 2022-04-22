<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSearchResults extends Component
{
    protected $listeners = ['searchProducts'];

    public $propertyValue;

    public $depositAmount;

    public function searchProducts($formData)
    {
        [$this->propertyValue, $this->depositAmount] = $formData;
    }

    public function render()
    {
        $searchProducts = $this->propertyValue && $this->depositAmount;

        if ($searchProducts) {
            $netLoan = $this->propertyValue - $this->depositAmount;
            $ltv = ($netLoan / $this->propertyValue) * 100;

            $products = Product::query()
                ->where('max_ltv', '>=', $ltv)
                ->orderBy('max_ltv')
                ->get()
                ->each(function (Product $product) use ($netLoan) {
                    $product->fee_amount = $netLoan * $product->fee / 100;
                    $product->gross_loan = $netLoan + $product->fee_amount;
                    $product->monthly_interest = $product->gross_loan * $product->interest_rate / 100 / 12;
                });
        } else {
            $netLoan = null;
            $ltv = null;

            $products = collect();
        }

        return view('livewire.product-search-results', [
            'searchProducts' => $searchProducts,
            'ltv' => $ltv,
            'netLoan' => $netLoan,
            'products' => $products,
        ]);
    }
}
