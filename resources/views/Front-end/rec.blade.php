@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Recommended Products for You</h1>
        <div class="row">
            @forelse ($recommendedProducts as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">€{{ $product->price }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>No products to recommend at the moment.</p>
            @endforelse
        </div>
    </div>
@endsection
