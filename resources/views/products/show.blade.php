@extends('layout')

@section('main')
<div class="container">
    <h1>Product Details</h1>
    <div class="mb-3">
        <h4>Name:</h4> <span>{{ $product->name }}</span>
    </div>
    <div class="mb-3">
        <h4>Price:</h4> <span>{{ $product->price }}</span>
    </div>
    <div class="mb-3">
        <h4>Quantity:</h4> <span>{{ $product->quantity }}</span>
    </div>
    <div class="mb-3">
        <h4>Description:</h4> <span>{{ $product->description }}</span>
    </div>
</div>
  
   
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection