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
    return response()->json($categories);
}

public function show($id)
{
    $category = DB::table('categories')->find($id);
    if ($category) {
        return response()->json($category);
    } else {
        return response()->json(['error' => 'Category not found'], 404);
    }
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $id = DB::table('categories')->insertGetId([
        'name' => $request->name,
    ]);

    return response()->json(['success' => 'Category created successfully.', 'id' => $id], 201);
}

public function destroy($id)
{
    $deleted = DB::table('categories')->where('id', $id)->delete();
    if ($deleted) {
        return response()->json(['success' => 'Category deleted successfully.']);
    } else {
        return response()->json(['error' => 'Category not found'], 404);
    }
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $updated = DB::table('categories')->where('id', $id)->update([
        'name' => $request->name,
    ]);

    if ($updated) {
        return response()->json(['success' => 'Category updated successfully.']);
    } else {
        return response()->json(['error' => 'Category not found'], 404);
    }
}
}