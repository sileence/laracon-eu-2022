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
