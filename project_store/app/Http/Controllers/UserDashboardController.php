<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Lấy một số sản phẩm mới nhất để hiển thị
        $recentProducts = Product::with('category')
            ->latest()
            ->limit(6)
            ->get();
            
        return view('user.dashboard', compact('user', 'recentProducts'));
    }
}
