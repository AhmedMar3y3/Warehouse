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
        

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('products'), $imageName);
    
            $validatedData['image'] = env('APP_URL') . '/public/products/' . $imageName;
        }
    


        $product = Product::create($validatedData);
        return response()->json('تم إنشاء المنتج بنجاح', 201);
    }
    public function updateProduct(updateProductRequest $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $product->update($validatedData);
        return response()->json('تم تحديث المنتج بنجاح', 200);
    }

    public function deleteProduct(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $product->delete();
        return response()->json('تم حذف المنتج بنجاح', 200);
    }

    public function showProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json('المنتج غير موجود', 404);
        }

        if ($product->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        return response()->json($product, 200);
    }
}

