<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI stats
        $totalRevenue     = Order::whereIn('status', ['completed', 'ready'])->sum('total');
        $todaysOrders     = Order::whereDate('created_at', today())->count();
        $totalProducts    = Product::count();
        $totalCustomers   = User::where('role', 'customer')->count();
        $totalStaff       = Staff::where('status', 'active')->count();
        $pendingSalaries  = Staff::where('status', 'active')
            ->whereDoesntHave('salaryPayments', fn ($q) => $q->where('payment_month', now()->format('Y-m')))
            ->count();

        // Orders by status counts
        $statusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Last 7 days revenue for chart
        $chartData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'label'   => $date->format('D'),
                'revenue' => Order::whereDate('created_at', $date->toDateString())
                                  ->whereIn('status', ['completed', 'ready'])
                                  ->sum('total'),
            ];
        });

        // Recent 6 orders
        $recentOrders = Order::latest()->take(6)->get();

        // Low stock / unavailable products
        $unavailableProducts = Product::where('is_available', false)->count();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'todaysOrders',
            'totalProducts',
            'totalCustomers',
            'totalStaff',
            'pendingSalaries',
            'statusCounts',
            'chartData',
            'recentOrders',
            'unavailableProducts'
        ));
    }
}
