<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = \App\Models\Product::count();
        $totalSales = \App\Models\Sale::sum('precio_venta');
        $lowStockProducts = \App\Models\Product::where('stock', '<', 10)->get();

        return view('dashboard', compact('totalProducts', 'totalSales', 'lowStockProducts'));
    }
}
