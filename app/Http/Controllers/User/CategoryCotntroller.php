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
        return response()->json('الفئة غير موجودة', 404);
    }
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

    return response()->json('تم إنشاء الفئة بنجاح', 201);
}

public function destroy($id)
{
    $deleted = DB::table('categories')->where('id', $id)->delete();
    if ($deleted) {
        return response()->json( 'تم حذف الفئة بنجاح.', 200);
    } else {
        return response()->json( 'الفئة غير موجودة' ,404);
    }
}
}