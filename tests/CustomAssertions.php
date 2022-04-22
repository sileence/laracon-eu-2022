<?php

namespace Tests;

use App\Dto\ProductQuote;

trait CustomAssertions
{
    public function assertProductQuote(ProductQuote $expectedQuote, ProductQuote $actualQuote)
    {
        self::assertTrue($expectedQuote->product->is($actualQuote->product), "The quote doesn't belong to the given product");
        self::assertSame($expectedQuote->feeAmount, $actualQuote->feeAmount, "The fee amounts don't match");
        self::assertSame($expectedQuote->grossLoanAmount, $actualQuote->grossLoanAmount, "The gross loan amounts don't match");
        self::assertSame($expectedQuote->monthlyInterest, $actualQuote->monthlyInterest, "The monthly interests don't match");
    }
}
