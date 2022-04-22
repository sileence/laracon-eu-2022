<?php

namespace Tests\Feature;

use App\Http\Livewire\ProductSearchForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProductSearchFormComponentTest extends TestCase
{
    /** @test */
    public function renders_the_products_search_form()
    {
        Livewire::test(ProductSearchForm::class)
            ->assertSeeText('Property value')
            ->assertSeeText('Deposit amount');
    }
}
