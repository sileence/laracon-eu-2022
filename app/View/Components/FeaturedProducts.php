<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class FeaturedProducts extends Component
{
    public function render()
    {
        $featuredProducts = Product::query()
            ->where('featured', true)
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('components.featured-products', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
