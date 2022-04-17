<div>
    <h1>Search products</h1>

    <form>
        <label for="property_value">Property value: </label>
        <input wire:model.defer="propertyValue" type="text" id="property_value">
        <br><br>
        <label for="deposit_amount">Deposit amount: </label>
        <input wire:model.defer="depositAmount" type="text" id="deposit_amount">
        <br><br>
        <button type="button" wire:click="$refresh">Find products</button>
    </form>

    @if ($searchProducts)
        <h2>Calculation results</h2>

        <p>LTV: {{ $ltv }}%</p>
        <p>Loan amount: £{{ number_format($netLoan) }}</p>

        <h2>Available products</h2>

        <ul>
            @foreach($products as $product)
                <li>
                    <strong>{{ $product->name }}</strong>
                    <br>Max LTV: {{ $product->max_ltv }}%
                    <br>Product Fee: {{ $product->fee }}%
                    <br>Product fee amount: £{{ number_format($product->fee_amount) }}
                    <br>Gross loan amount: £{{ number_format($product->gross_loan) }}
                    <br><br>
                </li>
            @endforeach
        </ul>
    @else
        <p>Please enter the values above to start searching for products.</p>
    @endif

    <h2>Featured products</h2>

    <ul>
        @foreach($featuredProducts as $product)
            <li>{{ $product->name }}</li>
        @endforeach
    </ul>
</div>
