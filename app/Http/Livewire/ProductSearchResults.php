<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Services\CalculateLtv;
use App\Services\GetProductQuotes;
use Livewire\Component;

class ProductSearchResults extends Component
{
    protected $listeners = ['searchProducts'];

    public $propertyValue;

    public $depositAmount;

    private CalculateLtv $calculateLtv;
    private GetProductQuotes $getProductQuotes;

    public function boot(CalculateLtv $calculateLtv, GetProductQuotes $getProductQuotes)
    {
        $this->calculateLtv = $calculateLtv;
        $this->getProductQuotes = $getProductQuotes;
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

            $products = $this->getProductQuotes->get($ltvCalculation);
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
