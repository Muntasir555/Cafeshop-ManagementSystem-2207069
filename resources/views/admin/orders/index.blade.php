@extends('admin.layout')
@section('title', 'Orders')
@section('breadcrumb', 'Orders')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">Orders</h1>
        <p class="page-subtitle">Track and manage all customer orders.</p>
    </div>
</div>

<!-- Status Filter Tabs -->
<div class="tab-bar">
    <a href="{{ route('admin.orders.index') }}"
       class="tab {{ !request('status') ? 'tab-active' : '' }}">All</a>
    @foreach($statuses as $key => $meta)
    <a href="{{ route('admin.orders.index', ['status' => $key]) }}"
       class="tab {{ request('status') === $key ? 'tab-active' : '' }}"
       style="{{ request('status') === $key ? 'border-color:'.$meta['color'].';color:'.$meta['color'].';' : '' }}">
        {{ $meta['label'] }}
    </a>
    @endforeach
</div>

<!-- Search -->
<div class="admin-card filter-card">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-form">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="filter-group">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by customer name or email…" class="filter-input">
        </div>
        <button type="submit" class="btn-secondary">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.orders.index', request()->only('status')) }}" class="btn-ghost">Clear</a>
        @endif
    </form>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Placed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
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
                    <td class="td-date">{{ $order->created_at->format('M j, g:i A') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-table">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="td-empty">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="pagination-wrap">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
