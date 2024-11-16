@extends('layout')

@section('main')
<div class="container">
    <h1>Bill Details</h1>
    <div class="mb-3">
        <strong>Customer Name:</strong> {{ $bill->customer_name }}
    </div>
    <div class="mb-3">
        <strong>Customer Phone:</strong> {{ $bill->customer_phone }}
    </div>
    <div class="mb-3">
        <strong>Total Price:</strong> ${{ $bill->total_price }}
    </div>
    <h3>Products</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bill->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>${{ $product->price * $product->pivot->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
