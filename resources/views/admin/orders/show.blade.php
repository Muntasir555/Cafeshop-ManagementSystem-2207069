@extends('admin.layout')
@section('title', 'Order #' . $order->id)
@section('breadcrumb', 'Order #' . $order->id)

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">Order #{{ $order->id }}</h1>
        <p class="page-subtitle">Placed {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn-secondary">← Back to Orders</a>
</div>

<div class="order-detail-grid">

    <!-- Order Items -->
    <div class="admin-card">
        <div class="card-header">
            <h2 class="card-title">Order Items</h2>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="item-name">{{ $item['name'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td class="td-total">${{ number_format($item['price'] * $item['qty'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="order-total-row">
                    <td colspan="3" class="order-total-label">Total</td>
                    <td class="td-total order-total-value">${{ number_format($order->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        @if($order->notes)
        <div class="order-notes">
            <strong>📝 Customer Notes:</strong> {{ $order->notes }}
        </div>
        @endif
    </div>

    <!-- Customer + Status Panel -->
    <div class="order-side-panel">

        <!-- Customer Info -->
        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Customer</h2>
            </div>
            <div class="customer-detail">
                <div class="customer-avatar-lg">{{ strtoupper(substr($order->customer_name, 0, 1)) }}</div>
                <div>
                    <p class="customer-detail-name">{{ $order->customer_name }}</p>
                    <p class="customer-detail-email">{{ $order->customer_email }}</p>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Order Status</h2>
            </div>
            @php $badge = \App\Models\Order::$statuses[$order->status]; @endphp
            <div class="current-status">
                <span class="status-pill status-pill-lg" style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};">
                    {{ $badge['label'] }}
                </span>
            </div>

            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="status-form">
                @csrf @method('PATCH')
                <label class="form-label">Update Status</label>
                <select name="status" class="form-select">
                    @foreach($statuses as $key => $meta)
                        <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                            {{ $meta['label'] }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary btn-full">Update Status</button>
            </form>
        </div>

    </div>

</div>
@endsection
