<?php

declare(strict_types=1);

namespace App\Contracts;

interface QuotableProduct
{
    public function getFee(): float;

    public function getInterestRate(): float;
}
