<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryCotntroller extends Controller
{
    
public function index()
{
    $categories = DB::table('categories')->where('user_id', auth()->id())->get();
    return view('categories.index', compact('categories'));
}

public function show($id)
{
    $category = Category::with('products')->findOrFail($id);
    return view('categories.show', compact('category'));
}


public function create()
{
    return view('categories.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

$category = DB::table('categories')->insert([
    'name' => $request->name,
    'user_id' => $request->user()->id,
]);

    return redirect()->route('categories.index');
}

public function destroy($id)
{
    $deleted = DB::table('categories')->where('id', $id)->delete();
    if ($deleted) {
        return redirect()->route('categories.index')->with('success', 'تم حذف الفئة بنجاح.');
    } else {
        return redirect()->route('categories.index')->with('error', 'الفئة غير موجودة.');
    }
    }
}
