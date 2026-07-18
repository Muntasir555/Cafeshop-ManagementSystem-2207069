@extends('admin.layout')
@section('title', 'Salary Payments')
@section('breadcrumb', 'Salary Payments')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">💰 Salary Payments</h1>
        <p class="page-subtitle">Full history of all salary payments made.</p>
    </div>
    <div class="page-title-actions">
        <a href="{{ route('admin.salaries.pending') }}" class="btn-secondary">⏳ Pending Salaries</a>
        <a href="{{ route('admin.salaries.create') }}" class="btn-primary">+ Record Payment</a>
    </div>
</div>

{{-- ── Filters ────────────────────────────────────── --}}
<div class="admin-card filter-card">
    <form method="GET" action="{{ route('admin.salaries.index') }}" class="filter-form">
        <div class="filter-group">
            <select name="staff_id" class="filter-select">
                <option value="">All Staff</option>
                @foreach($staffList as $member)
                    <option value="{{ $member->id }}" {{ request('staff_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <input type="month" name="month" value="{{ request('month') }}" class="filter-input" placeholder="Filter by month">
        </div>
        <button type="submit" class="btn-secondary">Filter</button>
        @if(request()->hasAny(['staff_id','month']))
            <a href="{{ route('admin.salaries.index') }}" class="btn-ghost">Clear</a>
        @endif
    </form>
</div>

{{-- ── Payments Table ──────────────────────────────── --}}
<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Staff Member</th>
                    <th>Month Paid For</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Date Paid</th>
                    <th>Paid By</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>
                        <div class="td-customer">
                            <span class="customer-avatar" style="background:#006241;color:#fff;">
                                {{ strtoupper(substr($payment->staff->name ?? '?', 0, 1)) }}
                            </span>
                            <div>
                                <span class="customer-name">{{ $payment->staff->name ?? 'Deleted Staff' }}</span>
                                @if($payment->staff)
                                    <span class="customer-email">{{ ucfirst($payment->staff->role) }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="font-weight:600;">{{ $payment->monthLabel() }}</td>
                    <td class="td-total">${{ number_format($payment->amount, 2) }}</td>
                    <td>{{ \App\Models\SalaryPayment::$methods[$payment->payment_method] ?? $payment->payment_method }}</td>
                    <td class="td-date">{{ $payment->payment_date->format('M j, Y') }}</td>
                    <td class="td-date">{{ $payment->paid_by }}</td>
                    <td class="td-date" style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $payment->note }}">
                        {{ $payment->note ?: '—' }}
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.salaries.destroy', $payment) }}"
                              onsubmit="return confirm('Void this payment record?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-table btn-table-danger">Void</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="td-empty">No salary payments recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="pagination-wrap">{{ $payments->links() }}</div>
    @endif
</div>

@push('styles')
<style>
.btn-table-danger { border-color:#c82014;color:#c82014; }
.btn-table-danger:hover { background:#c82014;color:#fff; }
</style>
@endpush
@endsection
