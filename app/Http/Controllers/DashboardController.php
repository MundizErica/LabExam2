<?php

namespace App\Http\Controllers;

use App\Models\Rice;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_rice' => Rice::count(),
            'total_orders' => Order::count(),
            'paid_orders' => Payment::where('status', 'paid')->count(),
            'unpaid_orders' => Payment::where('status', 'unpaid')->count(),
            'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
            'low_stock' => Rice::where('stock', '<', 10)->count(),
        ];

        $recentOrders = Order::with(['items.rice', 'payment'])->latest()->take(5)->get();
        
        return view('dashboard', compact('stats', 'recentOrders'));
    }
}
