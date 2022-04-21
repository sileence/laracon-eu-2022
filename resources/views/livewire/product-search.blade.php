<main class="calculator">
  <div>
    <div class="box sidebar">
      <form class="ph-24" wire:submit.prevent="$refresh">
        <fieldset>
          <legend>Search products</legend>

          <label for="property_value">
            <span class="label">Property value:</span>
            <input
              wire:model.defer="propertyValue"
              type="text"
              id="property_value"
            >
          </label>

          <label for="deposit_amount">
            <span class="label">Deposit amount:</span>
            <input
              wire:model.defer="depositAmount"
              type="text"
              id="deposit_amount"
            >
          </label>

          <button type="submit" class="button mt-30">
            Find products
          </button>
        </fieldset>
      </form>

      @if ($featuredProducts->count())
        <aside class="featured ph-24">
          <h2>Featured products</h2>

          <ul class="featuredList">
            @foreach($featuredProducts as $product)
              <li>{{ $product->name }}</li>
            @endforeach
          </ul>
        </aside>
      @endif
    </div>
  </div>


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
    </section>

  @else
    <div class="noResults">
      <strong>We currently do not have any products matching your criteria</strong>
      <p>Try adjusting your details on the left.</p>
    </div>
  @endif
</main>
