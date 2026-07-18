@extends('admin.layout')
@section('title', 'Staff')
@section('breadcrumb', 'Staff')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">Staff Management</h1>
        <p class="page-subtitle">Manage your BrewHaven team across all store locations.</p>
    </div>
    <div class="page-title-actions">
        <a href="{{ route('admin.staff.create') }}" class="btn-primary">+ Add Staff</a>
    </div>
</div>

{{-- ── Filters ─────────────────────────────────────────────── --}}
<div class="admin-card filter-card">
    <form method="GET" action="{{ route('admin.staff.index') }}" class="filter-form">
        <div class="filter-group">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search name or email…" class="filter-input">
        </div>
        <div class="filter-group">
            <select name="role" class="filter-select">
                <option value="">All Roles</option>
                @foreach($roles as $key => $meta)
                    <option value="{{ $key }}" {{ request('role') === $key ? 'selected' : '' }}>
                        {{ $meta['label'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <select name="status" class="filter-select">
                <option value="">All Statuses</option>
                @foreach($statuses as $key => $meta)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                        {{ $meta['label'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <select name="store_id" class="filter-select">
                <option value="">All Stores</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-secondary">Filter</button>
        @if(request()->hasAny(['search','role','status','store_id']))
            <a href="{{ route('admin.staff.index') }}" class="btn-ghost">Clear</a>
        @endif
    </form>
</div>

{{-- ── Staff Table ──────────────────────────────────────────── --}}
<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Staff Member</th>
                    <th>Role</th>
                    <th>Shift</th>
                    <th>Store</th>
                    <th>Salary / mo</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                @php
                    $roleMeta   = \App\Models\Staff::$roles[$member->role]   ?? ['label'=>$member->role,   'bg'=>'#eee','color'=>'#333'];
                    $statusMeta = \App\Models\Staff::$statuses[$member->status] ?? ['label'=>$member->status,'bg'=>'#eee','color'=>'#333'];
                @endphp
                <tr>
                    <td>
                        <div class="td-customer">
                            <span class="customer-avatar" style="background:#006241;color:#fff;">
                                {{ strtoupper(substr($member->name,0,1)) }}
                            </span>
                            <div>
                                <span class="customer-name">{{ $member->name }}</span>
                                <span class="customer-email">{{ $member->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="status-pill" style="background:{{ $roleMeta['bg'] }};color:{{ $roleMeta['color'] }};">
                            {{ $roleMeta['label'] }}
                        </span>
                    </td>
                    <td class="td-date">{{ \App\Models\Staff::$shifts[$member->shift] ?? $member->shift }}</td>
                    <td class="td-date">
                        @if($member->store)
                            <span title="{{ $member->store->address }}">📍 {{ $member->store->name }}</span>
                        @else
                            <span style="color:#aaa;">—</span>
                        @endif
                    </td>
                    <td class="td-total">${{ number_format($member->monthly_salary, 2) }}</td>
                    <td>
                        <span class="status-pill" style="background:{{ $statusMeta['bg'] }};color:{{ $statusMeta['color'] }};">
                            {{ $statusMeta['label'] }}
                        </span>
                    </td>
                    <td class="td-date">{{ $member->join_date->format('M j, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:0.4rem;">
                            <a href="{{ route('admin.staff.show', $member) }}" class="btn-table">View</a>
                            <a href="{{ route('admin.staff.edit', $member) }}" class="btn-table">Edit</a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $member) }}"
                                  onsubmit="return confirm('Remove {{ $member->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-table btn-table-danger">Del</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="td-empty">No staff members found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($staff->hasPages())
    <div class="pagination-wrap">{{ $staff->links() }}</div>
    @endif
</div>

@push('styles')
<style>
.btn-table-danger { border-color:#c82014;color:#c82014; }
.btn-table-danger:hover { background:#c82014;color:#fff; }
</style>
@endpush
@endsection
