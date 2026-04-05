<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Restaurant;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalRestaurants = Restaurant::count();
        $totalProducts = Product::count();
        $totalCategories = CategoryProduct::count();
        
        $totalRevenue = Transaction::where('status', 'success')->sum('total_price');
        $totalTransactions = Transaction::count();
        
        $todayTransactions = Transaction::whereDate('created_at', now())->count();
        $todayRevenue = Transaction::whereDate('created_at', now())->where('status', 'success')->sum('total_price');
        
        $recentTransactions = Transaction::with(['user', 'restaurant'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRestaurants',
            'totalProducts',
            'totalCategories',
            'totalRevenue',
            'totalTransactions',
            'todayTransactions',
            'todayRevenue',
            'recentTransactions',
            'recentUsers'
        ));
    }
}
