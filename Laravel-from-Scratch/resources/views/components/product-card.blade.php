<div class="card">
    <img class="card-img-top" 
         src="{{ asset($product->images->first()->path ?? 'storage/default.jpg') }}" 
         height="250" 
         alt="{{ $product->title }}">

    <div class="card-body">
        <h4 class="text-right"><strong>₹{{ number_format($product->price, 2) }}</strong></h4>
        <h5 class="card-title">{{ $product->title }}</h5>
        <p class="card-text">{{ $product->description }}</p>
        <p class="card-text"><strong>{{ $product->stock }} left</strong></p>

        @if (isset($cart))
            <p class="card-text">
                {{ $product->pivot->quantity }} in your cart
                <strong>(₹{{ number_format($product->total, 2) }})</strong>
            </p>

            <!-- Remove from Cart -->
            <form method="POST" 
                  action="{{ route('products.carts.destroy', ['product' => $product->id, 'cart' => $cart->id]) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-warning" type="submit">Remove From Cart</button>
            </form>
        @else
            <!-- Add to Cart -->
            <form method="POST" action="{{ route('products.carts.store', ['product' => $product->id]) }}">
                @csrf
                <button class="btn btn-success" type="submit">Add to Cart</button>
            </form>
        @endif
    </div>
</div>
