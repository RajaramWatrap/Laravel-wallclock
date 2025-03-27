@extends('layouts.app')

@section('content')
    @empty($products)
        <div class="alert alert-warning">
            The list of products is empty
        </div>
    @else
        <div class="row">
            @foreach ($products as $product)
                <div class="col-3">
                    @if ($product->images->isNotEmpty())
                        <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="img-fluid mb-2">
                    @endif
                    @include('components.product-card')
                </div>
            @endforeach
        </div>
    @endif
@endsection
