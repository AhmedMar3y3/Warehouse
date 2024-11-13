@extends('layout')

@section('main')
<div class="container">
    <h2>Category: {{ $category->name }}</h2>
    
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Back to Categories</a>

    <!-- List of Products in this Category -->
    <h3>Products in {{ $category->name }}</h3>

    @if($category->products->isEmpty())
        <p>No products found in this category.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category->products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
