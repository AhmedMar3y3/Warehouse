<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;


class BillController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::with('products')->where('user_id', auth()->id());
        if ($request->filled('search')) {
            $query->where('customer_name', 'LIKE', '%' . $request->search . '%');
        }

        $bills = $query->paginate(10); // Pagination
        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        $products = Product::where('quantity', '>', 0)->where('user_id', auth()->id())->get(); // Fetch only products with positive quantity
        return view('bills.create', compact('products'));
    }
    

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'customer_name' => 'required|string',
        'customer_phone' => 'required|string',
        'products' => 'required|array',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
    ], [
        'products.*.quantity.min' => 'يجب أن تكون الكمية على الأقل واحد لكل منتج.',  // Custom error message in Arabic
    ]);

    $products = $validatedData['products'];
    $totalPrice = 0;

    DB::beginTransaction();

    $bill = Bill::create([
        'customer_name' => $validatedData['customer_name'],
        'customer_phone' => $validatedData['customer_phone'],
        'total_price' => 0,
        'user_id' => auth()->id(),
    ]);

    foreach ($products as $item) {
        $product = Product::findOrFail($item['id']);

        if ($item['quantity'] > $product->quantity) {
            DB::rollBack();
            return redirect()->back()->with(
                'error' ,"الكمية المتاحة غير كافية للمنتج: {$product->name}"
            );

        }

        $product->decrement('quantity', $item['quantity']);
        $itemTotal = $product->price * $item['quantity'];
        $totalPrice += $itemTotal;
        $bill->products()->attach($product->id, ['quantity' => $item['quantity']]);
    }

    $bill->update(['total_price' => $totalPrice]);

    DB::commit();

    return redirect()->route('bills.index')->with('success', 'تم إنشاء الفاتورة بنجاح');
}

    
    public function show($id)
    {
        $bill = Bill::with('products')->findOrFail($id);
        return view('bills.show', compact('bill'));
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();
        return redirect()->route('bills.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }

}
