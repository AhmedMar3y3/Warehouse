@extends('layout')

@section('main')
<div class="container">
    <h1>Create Bill</h1>
    <form action="{{ route('bills.store') }}" method="POST">
        @csrf
        <!-- Customer Name -->
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" required>
        </div>

        <!-- Customer Phone -->
        <div class="mb-3">
            <label for="customer_phone" class="form-label">Customer Phone</label>
            <input type="text" name="customer_phone" id="customer_phone" class="form-control" required>
        </div>

        <!-- Products Section -->
        <div id="products-container">
            <div class="product-row mb-3">
                <label for="product_0" class="form-label">Product</label>
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <select name="products[0][id]" id="product_0" class="form-select" required>
                            <option value="" selected disabled>Select a product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ${{ $product->price }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="products[0][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 justify-content-between">
            <div class="col-auto">
            <!-- Add Product Button -->
            <button type="button" id="add-product" class="btn btn-primary">+</button>
            </div>
            <div class="col-auto">
            <!-- Submit Button -->
            <button type="submit" class="btn btn-success">Create</button>
            </div>
        </div>
    </form>
</div>
<script>
    const productsData = @json($products);  // Get product data as a JSON object
    let productIndex = 1;

    document.getElementById('add-product').addEventListener('click', function () {
        const productsContainer = document.getElementById('products-container');

        const newProductRow = document.createElement('div');
        newProductRow.classList.add('product-row', 'mb-3');

        let optionsHtml = '<option value="" selected disabled>Select a product</option>';
        productsData.forEach(product => {
            optionsHtml += `<option value="${product.id}" data-price="${product.price}">${product.name} - $${product.price}</option>`;
        });

        newProductRow.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <select name="products[${productIndex}][id]" class="form-select" required>
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[${productIndex}][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            </div>
        `;

        productsContainer.appendChild(newProductRow);
        productIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
        }
    });
</script>
@endsection

