<?php

namespace App\Models;

use App\Contracts\QuotableProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements QuotableProduct
{
    use HasFactory;

    protected $guarded = [];

    public function getFee(): float
    {
        return $this->fee;
    }

    public function getInterestRate(): float
    {
        return $this->interest_rate;
    }
}
