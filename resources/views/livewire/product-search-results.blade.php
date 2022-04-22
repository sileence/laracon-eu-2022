<div>
    @if ($searchProducts)
        <section class="results">
            <h2>Calculation results</h2>
            <div class="summary">
                <div>
                    <strong>LTV:</strong> {{ $ltv }}%
                </div>
                <div>
                    <strong>Loan amount:</strong> £{{ number_format($netLoan, 2) }}
                </div>
            </div>

            @if($products->isNotEmpty())
                <section class="availableProducts">
                    <h3>Available products</h3>

                    <ul class="productList">
                        @foreach($products as $product)
                            <li>
                                <article class="box product">
                                    <h4>{{ $product->name }}</h4>

                                    <dl class="productDetails">
                                        <dt>Max LTV</dt>
                                        <dd>{{ $product->max_ltv }}%</dd>

                                        <dt>Product Fee</dt>
                                        <dd>{{ $product->fee }}%</dd>

                                        <dt>Interest rate</dt>
                                        <dd>{{ $product->interest_rate }}%</dd>

                                        <dt>Product fee amount</dt>
                                        <dd>£{{ number_format($product->fee_amount, 2) }}</dd>

                                        <dt>Gross loan amount</dt>
                                        <dd>£{{ number_format($product->gross_loan, 2) }}</dd>

                                        <dt>Monthly interest</dt>
                                        <dd>£{{ number_format($product->monthly_interest, 2) }}</dd>
                                    </dl>
                                </article>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @else
                <div class="noResults">
                    <strong>No product matches your search criteria</strong>
                    <p>Try adjusting the details on the left, for example, increasing the deposit amount.</p>
                </div>
            @endif
        </section>
    @else
        <div class="noResults">
            <strong>Complete the form on the left</strong>
            <p>To begin your product search, please enter a property value and a deposit amount.</p>
        </div>
    @endif
</div>
