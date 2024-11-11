<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeProductRequest;
use App\Http\Requests\updateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products;
        return response()->json($products, 200);
    }
    public function storeNewProduct(storeProductRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $product = Product::create($validatedData);
        return response()->json('product created successfully', 201);
    }
    public function updateProduct(updateProductRequest $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json('Unauthorized', 403);
        }

        $validatedData = $request->validated();
        $product->update($validatedData);
        return response()->json('product updated successfully', 200);
    }

    public function deleteProduct(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json('Unauthorized', 403);
        }

        $product->delete();
        return response()->json('product deleted successfully', 200);
    }

    public function showProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json('Product not found', 404);
        }

        if ($product->user_id !== auth()->id()) {
            return response()->json('Unauthorized', 403);
        }

        return response()->json($product, 200);
    }

public function sellProduct(Request $request, Product $product)
{
    if ($product->user_id !== auth()->user()->id) {
        return response()->json('Unauthorized', 403);
    }

    $quantityToSell = $request->input('quantity');

    if ($quantityToSell > $product->quantity) {
        return response()->json('Not enough quantity in stock', 400);
    }

    $product->update([
        'quantity' => $product->quantity - $quantityToSell
    ]);

    return response()->json('product sold successfully', 200);
}
public function sellMultipleProducts(Request $request)
{
    // Validate that the request contains an array of products with 'id' and 'quantity'
    $validatedData = $request->validate([
        'products' => 'required|array',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
    ]);

    // Retrieve the list of products with their quantities
    $products = $validatedData['products'];
    $userId = auth()->id();

    // Loop through each product to check availability and deduct quantity
    foreach ($products as $item) {
        $product = Product::where('id', $item['id'])->where('user_id', $userId)->first();

        // Check if the product exists and belongs to the authenticated user
        if (!$product) {
            return response()->json(['error' => "Product with ID {$item['id']} not found or unauthorized."], 404);
        }

        // Check if there's enough quantity
        if ($item['quantity'] > $product->quantity) {
            return response()->json(['error' => "Not enough quantity in stock for product with ID {$item['id']}"], 400);
        }

        // Deduct the quantity
        $product->update([
            'quantity' => $product->quantity - $item['quantity']
        ]);
    }

    return response()->json('Products sold successfully', 200);
}

}
