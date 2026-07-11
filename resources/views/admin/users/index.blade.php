@extends('admin.layout')
@section('title', 'Customers')
@section('breadcrumb', 'Customers')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">Customers</h1>
        <p class="page-subtitle">All registered customer accounts.</p>
    </div>
</div>

<!-- Search -->
<div class="admin-card filter-card">
    <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form">
        <div class="filter-group">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or email…" class="filter-input">
        </div>
        <button type="submit" class="btn-secondary">Search</button>
        @if(request('search'))
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
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="td-customer">
                            <span class="customer-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            <span class="customer-name">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="customer-email">{{ $user->email }}</td>
                    <td class="td-date">{{ $user->created_at->format('M j, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="td-empty">No customers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="pagination-wrap">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
