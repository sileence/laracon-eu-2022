<main>
  <form>
    <fieldset>
      <legend>Search products</legend>

      <label for="property_value">
        <span>Property value:</span>
        <input wire:model.defer="propertyValue" type="text" id="property_value">
      </label>

      <label for="deposit_amount">
        <span>Deposit amount:</span>
        <input wire:model.defer="depositAmount" type="text" id="deposit_amount">
      </label>

      <button type="button" wire:click="$refresh">Find products</button>
    </fieldset>
  </form>

  @if ($searchProducts)
    <section>
      <h2>Calculation results</h2>

      <p>LTV: {{ $ltv }}%</p>
      <p>Loan amount: £{{ number_format($netLoan, 2) }}</p>
    </section>

    <section>
      <h2>Available products</h2>

      <ul>
        @foreach($products as $product)
        <li>
          <article>
            <h3>{{ $product->name }}</h3>
            <dl>
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
    <p>Please enter the values above to start searching for products.</p>
  @endif

  @if ($featuredProducts->count())
    <section>
      <h2>Featured products</h2>

      <ul>
        @foreach($featuredProducts as $product)
          <li>{{ $product->name }}</li>
        @endforeach
      </ul>
    </section>
  @endif
</main>
