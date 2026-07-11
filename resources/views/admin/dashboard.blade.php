@extends('admin.layout')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ auth()->user()->name }}! ☕</h1>
        <p class="page-subtitle">Here's what's happening at BrewHaven today.</p>
    </div>
    <div class="page-title-actions">
        <span class="date-badge">{{ now()->format('l, F j, Y') }}</span>
    </div>
</div>

<!-- ═══ KPI CARDS ═══ -->
<div class="kpi-grid">
    <div class="kpi-card kpi-revenue">
        <div class="kpi-icon">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Total Revenue</span>
            <span class="kpi-value">${{ number_format($totalRevenue, 2) }}</span>
            <span class="kpi-sub">From completed orders</span>
        </div>
    </div>

    <div class="kpi-card kpi-orders">
        <div class="kpi-icon">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Today's Orders</span>
            <span class="kpi-value">{{ $todaysOrders }}</span>
            <span class="kpi-sub">Orders placed today</span>
        </div>
    </div>

    <div class="kpi-card kpi-products">
        <div class="kpi-icon">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/></svg>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Menu Items</span>
            <span class="kpi-value">{{ $totalProducts }}</span>
            @if($unavailableProducts > 0)
                <span class="kpi-sub kpi-sub-warn">{{ $unavailableProducts }} currently hidden</span>
            @else
                <span class="kpi-sub">All items available</span>
            @endif
        </div>
    </div>

    <div class="kpi-card kpi-customers">
        <div class="kpi-icon">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Customers</span>
            <span class="kpi-value">{{ $totalCustomers }}</span>
            <span class="kpi-sub">Registered accounts</span>
        </div>
    </div>
</div>

<!-- ═══ CHART + STATUS BREAKDOWN ═══ -->
<div class="dashboard-mid-grid">

    <!-- Sales Chart -->
    <div class="admin-card chart-card">
        <div class="card-header">
            <h2 class="card-title">Revenue — Last 7 Days</h2>
        </div>
        <div class="chart-wrap">
            <canvas id="salesChart" height="220"></canvas>
        </div>
    </div>

    <!-- Order Status Breakdown -->
    <div class="admin-card status-card">
        <div class="card-header">
            <h2 class="card-title">Order Status</h2>
            <a href="{{ route('admin.orders.index') }}" class="card-link">View all →</a>
        </div>
        <div class="status-list">
            @foreach(\App\Models\Order::$statuses as $key => $meta)
            @php $cnt = $statusCounts[$key] ?? 0; @endphp
            <div class="status-row">
                <span class="status-pill" style="background:{{ $meta['bg'] }};color:{{ $meta['color'] }};">
                    {{ $meta['label'] }}
                </span>
                <div class="status-bar-wrap">
                    @php $total = array_sum($statusCounts) ?: 1; @endphp
                    <div class="status-bar" style="width:{{ round($cnt / $total * 100) }}%; background:{{ $meta['color'] }};"></div>
                </div>
                <span class="status-count">{{ $cnt }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ═══ RECENT ORDERS ═══ -->
<div class="admin-card">
    <div class="card-header">
        <h2 class="card-title">Recent Orders</h2>
        <a href="{{ route('admin.orders.index') }}" class="card-link">View all orders →</a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                @php $badge = \App\Models\Order::$statuses[$order->status]; @endphp
                <tr>
                    <td class="td-id">#{{ $order->id }}</td>
                    <td>
                        <div class="td-customer">
                            <span class="customer-avatar">{{ strtoupper(substr($order->customer_name, 0, 1)) }}</span>
                            <div>
                                <span class="customer-name">{{ $order->customer_name }}</span>
                                <span class="customer-email">{{ $order->customer_email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $order->item_count }} item(s)</td>
                    <td class="td-total">${{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="status-pill" style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};">
                            {{ $badge['label'] }}
                        </span>
                    </td>
                    <td class="td-date">{{ $order->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-table">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="td-empty">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const chartData = @json($chartData);

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: chartData.map(d => d.label),
        datasets: [{
            label: 'Revenue ($)',
            data: chartData.map(d => parseFloat(d.revenue) || 0),
            backgroundColor: '#006241',
            borderRadius: 6,
            borderSkipped: false,
            hoverBackgroundColor: '#cba258',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => `$${ctx.parsed.y.toFixed(2)}`
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f0f0f0' },
                ticks: { callback: v => '$' + v }
            },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
