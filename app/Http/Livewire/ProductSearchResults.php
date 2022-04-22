<?php

namespace App\Http\Livewire;

use App\Dto\LtvCalculation;
use App\Models\Product;
use App\Services\CalculateLtv;
use App\Services\GetProductQuotes;
use Illuminate\Support\Collection;
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
        $ltvCalculation = $this->calculateLtv();
        $productQuotes = $this->getProductQuotes($ltvCalculation);

        return view('livewire.product-search-results', [
            'ltvCalculation' => $ltvCalculation,
            'productQuotes' => $productQuotes,
        ]);
    }

    private function calculateLtv(): ?LtvCalculation
    {
        if ($this->propertyValue === null || $this->depositAmount === null) {
            return null;
        }

        return $this->calculateLtv->calculate($this->propertyValue, $this->depositAmount);
    }

    private function getProductQuotes(?LtvCalculation $ltvCalculation): Collection
    {
        if ($ltvCalculation === null) {
            return collect();
        }

        return $this->getProductQuotes->get($ltvCalculation);
    }
}
