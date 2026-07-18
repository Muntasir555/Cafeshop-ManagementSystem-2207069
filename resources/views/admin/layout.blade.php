<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — BrewHaven Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

<!-- ═══ SIDEBAR ═══ -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="42" height="42">
                <circle cx="50" cy="50" r="48" fill="#cba258"/>
                <text x="50" y="38" text-anchor="middle" fill="#1E3932" font-family="serif" font-size="11" font-weight="700" letter-spacing="2">BREW</text>
                <text x="50" y="58" text-anchor="middle" fill="#1E3932" font-family="serif" font-size="22" font-weight="700">☕</text>
                <text x="50" y="74" text-anchor="middle" fill="#1E3932" font-family="serif" font-size="9" letter-spacing="3">HAVEN</text>
            </svg>
            <div class="sidebar-logo-text">
                <span class="logo-name">BrewHaven</span>
                <span class="logo-role">Admin Panel</span>
            </div>
        </a>
        <button class="sidebar-close" id="sidebarClose" onclick="toggleSidebar()">✕</button>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            </span>
            Dashboard
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            </span>
            Orders
            @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.6 6.62c-1.44 0-2.8.56-3.77 1.53L12 10.66 10.48 12h.01L7.8 14.39c-.64.64-1.49.99-2.4.99-1.87 0-3.39-1.51-3.39-3.38S3.53 8.62 5.4 8.62c.91 0 1.76.35 2.44 1.03l1.13 1 1.51-1.34L9.22 8.2C8.2 7.18 6.84 6.62 5.4 6.62 2.42 6.62 0 9.04 0 12s2.42 5.38 5.4 5.38c1.44 0 2.8-.56 3.77-1.53l2.83-2.5.01.01L13.52 12h-.01l2.69-2.39c.64-.64 1.49-.99 2.4-.99 1.87 0 3.39 1.51 3.39 3.38s-1.52 3.38-3.39 3.38c-.9 0-1.76-.35-2.44-1.03l-1.14-1.01-1.51 1.34 1.27 1.12c1.02 1.01 2.37 1.57 3.82 1.57 2.98 0 5.4-2.41 5.4-5.38s-2.42-5.38-5.4-5.38z"/></svg>
            </span>
            Products
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            </span>
            Customers
            @php $pendingUserCount = \App\Models\User::where('role','customer')->where('status','pending')->count(); @endphp
            @if($pendingUserCount > 0)
                <span class="nav-badge">{{ $pendingUserCount }}</span>
            @endif
        </a>

        {{-- Staff --}}
        <a href="{{ route('admin.staff.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
            </span>
            Staff
        </a>

        {{-- Salaries --}}
        <a href="{{ route('admin.salaries.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
            </span>
            Salaries
            @php $pendingSalaryCount = \App\Models\Staff::where('status','active')->whereDoesntHave('salaryPayments', fn($q) => $q->where('payment_month', now()->format('Y-m')))->count(); @endphp
            @if($pendingSalaryCount > 0)
                <span class="nav-badge">{{ $pendingSalaryCount }}</span>
            @endif
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-user-card">
            <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="admin-user-info">
                <span class="admin-user-name">{{ auth()->user()->name }}</span>
                <span class="admin-user-email">{{ auth()->user()->email }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout">
                <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>

<!-- ═══ OVERLAY (mobile) ═══ -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- ═══ MAIN CONTENT ═══ -->
<div class="admin-main" id="adminMain">

    <!-- Top Header -->
    <header class="admin-header">
        <button class="header-hamburger" onclick="toggleSidebar()" aria-label="Open menu">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
        </button>

        <div class="header-breadcrumb">
            <span class="breadcrumb-cafe">BrewHaven</span>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-page">@yield('breadcrumb', 'Dashboard')</span>
        </div>

        <div class="header-actions">
            <a href="{{ url('/') }}" class="header-btn-view" target="_blank">
                <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                View Site
            </a>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="flash-msg flash-success" id="flashMsg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            {{ session('success') }}
            <button onclick="document.getElementById('flashMsg').remove()" class="flash-close">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div class="flash-msg flash-error" id="flashMsg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            {{ session('error') }}
            <button onclick="document.getElementById('flashMsg').remove()" class="flash-close">✕</button>
        </div>
    @endif

    <!-- Page Content -->
    <div class="admin-content">
        @yield('content')
    </div>

</div>

<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
