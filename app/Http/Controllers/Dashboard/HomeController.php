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
        $products = Product::count();
        $categories = Category::count();
        $bills = Bill::count();
        $revenue = Bill::sum('total_price');
        $revenueToday = Bill::whereDate('created_at', today())->sum('total_price');
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
