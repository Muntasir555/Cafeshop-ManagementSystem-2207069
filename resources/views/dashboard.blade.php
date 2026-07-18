<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard — BrewHaven Coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <style>
        body { background: #f8faf9; font-family: 'Lato', sans-serif; color: #1E3932; margin: 0; padding-bottom: 4rem; }
        .dashboard-container { max-width: 1000px; margin: 3rem auto; padding: 0 1.5rem; }
        
        .dash-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; border-bottom: 1px solid #e0e8e4; padding-bottom: 1rem; }
        .dash-title { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #006241; margin: 0; }
        .btn-menu { background: #006241; color: #fff; padding: 0.6rem 1.2rem; border-radius: 999px; text-decoration: none; font-weight: 700; transition: 0.2s; }
        .btn-menu:hover { background: #00754a; }

        .dash-grid { display: grid; grid-template-columns: 300px 1fr; gap: 2rem; align-items: start; }
        @media (max-width: 768px) { .dash-grid { grid-template-columns: 1fr; } }

        .profile-card { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,98,65,0.06); text-align: center; }
        .profile-avatar { width: 80px; height: 80px; background: #006241; color: #fff; font-size: 2.5rem; font-weight: 700; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .profile-name { font-size: 1.4rem; font-weight: 700; margin: 0 0 0.25rem; }
        .profile-email { color: #5c6b66; margin: 0 0 1.5rem; }
        .profile-meta { font-size: 0.85rem; color: #7f8c8d; border-top: 1px solid #f0f4f2; padding-top: 1rem; }

        .orders-card { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,98,65,0.06); }
        .orders-title { font-size: 1.2rem; font-weight: 700; margin: 0 0 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
        
        .order-list { display: flex; flex-direction: column; gap: 1rem; }
        .order-item { border: 1px solid #e0e8e4; border-radius: 12px; padding: 1.25rem; transition: 0.2s; }
        .order-item:hover { border-color: #006241; box-shadow: 0 4px 12px rgba(0,98,65,0.05); }
        
        .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px dashed #e0e8e4; padding-bottom: 0.75rem; }
        .order-id { font-weight: 700; color: #006241; }
        .order-date { font-size: 0.85rem; color: #7f8c8d; }
        
        .order-body { display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
        .order-items-list { flex: 1; font-size: 0.95rem; color: #333; line-height: 1.5; }
        .order-total { font-size: 1.2rem; font-weight: 900; color: #1E3932; }

        .order-footer { display: flex; gap: 0.5rem; margin-top: 1rem; }
        .badge { padding: 0.3rem 0.8rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-pending { background: #fff8e1; color: #b45309; border: 1px solid #fbbc05; }
        .badge-ready { background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; }
        .badge-completed { background: #d4e9e2; color: #006241; border: 1px solid #006241; }
        .badge-cancelled { background: #fdecea; color: #c82014; border: 1px solid #fca5a5; }
        .badge-paid { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-failed { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        .empty-orders { text-align: center; padding: 3rem 1rem; color: #5c6b66; }
        .empty-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<header class="menu-navbar">
    <div class="menu-nav-inner">
        <a href="/" class="menu-nav-logo" aria-label="BrewHaven Home">
            <svg class="menu-nav-logo-circle" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="48" fill="#006241"/>
                <text x="50" y="38" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="11" font-weight="700" letter-spacing="2">BREW</text>
                <text x="50" y="58" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="22" font-weight="700">☕</text>
                <text x="50" y="74" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="9" letter-spacing="3">HAVEN</text>
            </svg>
            <span>BrewHaven</span>
        </a>
        <nav class="menu-nav-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('menu') }}">Menu</a>
            <a href="{{ url('/#rewards-strip') }}">Rewards</a>
            <a href="{{ url('/#store-section') }}">Find a Store</a>
        </nav>
        <div class="menu-nav-actions">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="btn-nav-join">Log out</a>
            </form>
        </div>
    </div>
</header>

<div class="dashboard-container">
    <div class="dash-header">
        <h1 class="dash-title">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!</h1>
        <a href="{{ route('menu') }}" class="btn-menu">Order Now →</a>
    </div>

    <div class="dash-grid">
        {{-- Profile Sidebar --}}
        <aside class="profile-card">
            <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <h2 class="profile-name">{{ auth()->user()->name }}</h2>
            <p class="profile-email">{{ auth()->user()->email }}</p>
            <div class="profile-meta">
                BrewHaven Member since {{ auth()->user()->created_at->format('F Y') }}
            </div>
        </aside>

        {{-- Orders Main Area --}}
        <main class="orders-card">
            <h2 class="orders-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7v-7zm4-3h2v10h-2V7zm4 6h2v4h-2v-4z"/></svg>
                Your Order History
            </h2>

            @if($orders->isEmpty())
                <div class="empty-orders">
                    <div class="empty-icon">☕</div>
                    <h3>No orders yet</h3>
                    <p>When you place an order, it will appear here so you can track its status.</p>
                    <a href="{{ route('menu') }}" class="btn-menu" style="display:inline-block; margin-top:1rem;">Browse Menu</a>
                </div>
            @else
                <div class="order-list">
                    @foreach($orders as $order)
                        <div class="order-item">
                            <div class="order-header">
                                <span class="order-id">Order #{{ $order->id }}</span>
                                <span class="order-date">{{ $order->created_at->format('M j, Y • g:i A') }}</span>
                            </div>
                            <div class="order-body">
                                <div class="order-items-list">
                                    @php
                                        // Pluck the quantity and name of each item
                                        $itemStrings = collect($order->items)->map(function($item) {
                                            return $item['qty'] . 'x ' . $item['name'];
                                        })->implode(', ');
                                    @endphp
                                    {{ $itemStrings }}
                                </div>
                                <div class="order-total">${{ number_format($order->total, 2) }}</div>
                            </div>
                            <div class="order-footer">
                                {{-- Kitchen Status --}}
                                @if($order->status === 'pending')
                                    <span class="badge badge-pending">Preparing</span>
                                @elseif($order->status === 'ready')
                                    <span class="badge badge-ready">Ready for Pickup</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge badge-completed">Completed</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge badge-cancelled">Cancelled</span>
                                @endif

                                {{-- Payment Status (only show if it's Stripe, not standard pending) --}}
                                @if($order->payment_method === 'stripe')
                                    @if($order->payment_status === 'paid')
                                        <span class="badge badge-paid">Paid Online</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="badge badge-failed">Payment Failed</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

</body>
</html>
