@extends('admin.layout')
@section('title', 'Customers')
@section('breadcrumb', 'Customers')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">Customers</h1>
        <p class="page-subtitle">Manage registered customer accounts and approval requests.</p>
    </div>
</div>

{{-- ── Tab Navigation ──────────────────────────────────────── --}}
<div class="user-tabs" id="userTabs">
    <button class="user-tab active" onclick="switchTab('approved', this)" id="tab-approved">
        ✅ Approved Customers
        <span class="tab-count">{{ $approvedUsers->total() }}</span>
    </button>
    <button class="user-tab" onclick="switchTab('pending', this)" id="tab-pending">
        ⏳ Pending Requests
        @if($pendingUsers->count() > 0)
            <span class="tab-count tab-count-pending">{{ $pendingUsers->count() }}</span>
        @endif
    </button>
    @if($rejectedUsers->count() > 0)
    <button class="user-tab" onclick="switchTab('rejected', this)" id="tab-rejected">
        ❌ Rejected
        <span class="tab-count tab-count-rejected">{{ $rejectedUsers->count() }}</span>
    </button>
    @endif
</div>

{{-- ── APPROVED CUSTOMERS TAB ──────────────────────────────── --}}
<div class="tab-panel" id="panel-approved">

    <!-- Search -->
    <div class="admin-card filter-card">
        <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Search by name or email…" class="filter-input">
            </div>
            <button type="submit" class="btn-secondary">Search</button>
            @if($search)
                <a href="{{ route('admin.users.index') }}" class="btn-ghost">Clear</a>
            @endif
        </form>
    </div>

    <div class="admin-card">
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approvedUsers as $user)
                    <tr>
                        <td>
                            <div class="td-customer">
                                <span class="customer-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                <span class="customer-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="customer-email">{{ $user->email }}</td>
                        <td>
                            <span class="status-pill status-approved">✓ Approved</span>
                        </td>
                        <td class="td-date">{{ $user->created_at->format('M j, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="td-empty">No approved customers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($approvedUsers->hasPages())
        <div class="pagination-wrap">
            {{ $approvedUsers->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ── PENDING REQUESTS TAB ────────────────────────────────── --}}
<div class="tab-panel" id="panel-pending" style="display:none;">
    <div class="admin-card">
        @if($pendingUsers->isEmpty())
            <div class="td-empty" style="padding: 3rem; text-align:center;">
                <div style="font-size:2.5rem; margin-bottom:0.75rem;">🎉</div>
                <p style="color:#5c6b66;">No pending registrations. You're all caught up!</p>
            </div>
        @else
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingUsers as $user)
                    <tr>
                        <td>
                            <div class="td-customer">
                                <span class="customer-avatar" style="background:#fff8e1; color:#b45309; border:2px solid #fbbc05;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <span class="customer-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="customer-email">{{ $user->email }}</td>
                        <td class="td-date">{{ $user->created_at->format('M j, Y') }}</td>
                        <td>
                            <div style="display:flex; gap:0.5rem; align-items:center;">
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-approve"
                                            onclick="return confirm('Approve {{ $user->name }}?')"
                                            title="Approve this user">
                                        ✓ Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.users.reject', $user) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-reject"
                                            onclick="return confirm('Reject {{ $user->name }}? They will not be able to log in.')"
                                            title="Reject this user">
                                        ✕ Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- ── REJECTED TAB ─────────────────────────────────────────── --}}
@if($rejectedUsers->count() > 0)
<div class="tab-panel" id="panel-rejected" style="display:none;">
    <div class="admin-card">
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rejectedUsers as $user)
                    <tr>
                        <td>
                            <div class="td-customer">
                                <span class="customer-avatar" style="background:#fdecea; color:#c82014; border:2px solid #c82014;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <span class="customer-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="customer-email">{{ $user->email }}</td>
                        <td class="td-date">{{ $user->created_at->format('M j, Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-approve" title="Re-approve this user">
                                    ✓ Re-approve
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
function switchTab(name, btn) {
    // Hide all panels & deactivate all tabs
    document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.user-tab').forEach(t => t.classList.remove('active'));

    // Show selected panel & activate tab
    const panel = document.getElementById('panel-' + name);
    if (panel) panel.style.display = 'block';
    btn.classList.add('active');
}

// Auto-open pending tab if there are pending users and URL hash says so
document.addEventListener('DOMContentLoaded', () => {
    @if($pendingUsers->count() > 0 && session('open_pending'))
        switchTab('pending', document.getElementById('tab-pending'));
    @endif
});
</script>
@endpush

@push('styles')
<style>
/* ── Tab Nav ─────────────────────────────────────── */
.user-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}
.user-tab {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    border: 2px solid #dde3e0;
    border-radius: 8px;
    background: #fff;
    color: #5c6b66;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
}
.user-tab:hover { border-color: #006241; color: #006241; }
.user-tab.active {
    background: #006241;
    border-color: #006241;
    color: #fff;
}
.tab-count {
    background: rgba(255,255,255,0.25);
    color: inherit;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 999px;
    padding: 0.1rem 0.55rem;
    min-width: 22px;
    text-align: center;
}
.user-tab:not(.active) .tab-count { background: #f0f4f2; color: #5c6b66; }
.tab-count-pending { background: #fff8e1 !important; color: #b45309 !important; }
.user-tab.active .tab-count-pending { background: rgba(255,255,255,0.2) !important; color: #fff !important; }
.tab-count-rejected { background: #fdecea !important; color: #c82014 !important; }

/* ── Approve / Reject Buttons ────────────────────── */
.btn-approve {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.4rem 0.9rem;
    background: #d4e9e2;
    color: #006241;
    border: 1.5px solid #006241;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.18s, color 0.18s;
}
.btn-approve:hover { background: #006241; color: #fff; }

.btn-reject {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.4rem 0.9rem;
    background: #fdecea;
    color: #c82014;
    border: 1.5px solid #c82014;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.18s, color 0.18s;
}
.btn-reject:hover { background: #c82014; color: #fff; }

/* ── Status Pill ─────────────────────────────────── */
.status-pill {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 999px;
    padding: 0.25rem 0.7rem;
}
.status-approved { background: #c8f5e2; color: #00754a; }
</style>
@endpush
@endsection

