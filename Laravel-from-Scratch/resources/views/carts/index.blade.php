@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Your Cart</h1>

        @if (!isset($cart) || $cart->products->isEmpty())
            <div class="alert alert-warning">
                Your cart is empty.
            </div>
            
        @else
            <h4 class="text-center">Your Cart Total: <strong>{{ $cart->total }}</strong></h4>
            
            <a class="btn btn-success mb-3" href="{{ route('orders.create') }}">
                Start Order
            </a>

            <div class="row">
                @foreach ($cart->products as $product)
                    <div class="col-md-3 mb-4">
                        @include('components.product-card', ['product' => $product, 'cart' => $cart])
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
