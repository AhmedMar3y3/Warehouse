<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Bill;

class HomeController extends Controller
{
    public function loadDashboard()
    {
        $user = auth()->user();
        $products = Product::where('user_id', $user->id)->count();
        $categories = Category::where('user_id', $user->id)->count();
        $bills = Bill::where('user_id', $user->id)->count();
        $revenue = Bill::where('user_id', $user->id)->sum('total_price');
        $revenueToday = Bill::where('user_id', $user->id)->whereDate('created_at', today())->sum('total_price');
        return view('dashboard', 
        compact(
            'products',
            'categories',
            'bills',
            'revenue',
            'revenueToday',
        ));
    }
}
