<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Bill;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function loadDashboard()
    {
        $user = auth()->user();
        $products = Product::where('user_id', $user->id)->count();
        $categories = Category::where('user_id', $user->id)->count();
        $bills = Bill::where('user_id', $user->id)->count();
        $revenue = Bill::where('user_id', $user->id)->sum('total_price');
        $averageBillPrice = Bill::where('user_id', $user->id)->avg('total_price');
        $revenueToday = Bill::where('user_id', $user->id)->whereDate('created_at', today())->sum('total_price');
        
        $dailyRevenue = Bill::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();
    
        $last7DaysRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $last7DaysRevenue[$date] = $dailyRevenue[$date] ?? 0;
        }
    
        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'bills' => $bills,
            'revenue' => $revenue,
            'revenueToday' => $revenueToday,
            'averageBillPrice' => $averageBillPrice,
            'last7DaysRevenue' => $last7DaysRevenue
        ]);
    }
}


