@extends('layouts.app')

@section('content')
    <h1>Order Details</h1>

    <h4 class="text-center"><strong>Grand Total: </strong>₹{{ number_format($cart->total, 2) }}</h4>

    <!-- Order Form -->
    <div class="text-center mb-3">
        <form class="d-inline" method="POST" action="{{ route('orders.store') }}">
            @csrf

            <!-- Address Field -->
            <div class="form-group">
                <label for="address">Delivery Address</label>
                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" required value="{{ old('address') }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-success mt-3" type="submit">Confirm Order</button>
        </form>
    </div>

    <!-- Order Summary Table -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-light">
                <th>Product</th>
                <th>Price (₹)</th>
                <th>Quantity</th>
                <th>Total (₹)</th>
            </thead>
            <tbody>
                @foreach ($cart->products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset($product->images->first()->path ?? 'storage/default.jpg') }}" width="100">
                            {{ $product->title }}
                        </td>
                        <td>₹{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>₹{{ number_format($product->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
