<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryCotntroller extends Controller
{
    
public function index()
{
    $categories = DB::table('categories')->get();
    return view('categories.index', compact('categories'));
}

public function show($id)
{
    $category = DB::table('categories')->find($id);
    return view('categories.show', compact('category'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    DB::table('categories')->insert([
        'name' => $request->name,
    ]);

    return redirect()->route('categories.index')->with('success', 'Category created successfully.');
}

public function destroy($id)
{
    DB::table('categories')->delete($id);
    return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    DB::table('categories')->where('id', $id)->update([
        'name' => $request->name,
    ]);

    return response()->json(['success' => 'Category updated successfully.']);
}
}