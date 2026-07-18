@extends('admin.layout')
@section('title', $staff->name)
@section('breadcrumb', 'Staff Profile')

@section('content')
@php
    $roleMeta   = \App\Models\Staff::$roles[$staff->role]      ?? ['label'=>$staff->role,   'bg'=>'#eee','color'=>'#333'];
    $statusMeta = \App\Models\Staff::$statuses[$staff->status] ?? ['label'=>$staff->status, 'bg'=>'#eee','color'=>'#333'];
    $shiftLabel = \App\Models\Staff::$shifts[$staff->shift]    ?? $staff->shift;
    $currentMonth = now()->format('Y-m');
    $isPaid = $staff->isPaidForMonth($currentMonth);
@endphp

<div class="page-title-row">
    <div>
        <h1 class="page-title">{{ $staff->name }}</h1>
        <p class="page-subtitle">Staff Profile & Payment History</p>
    </div>
    <div class="page-title-actions">
        <a href="{{ route('admin.salaries.create', ['staff_id' => $staff->id]) }}" class="btn-primary">
            💰 Pay Salary
        </a>
        <a href="{{ route('admin.staff.edit', $staff) }}" class="btn-secondary">Edit</a>
        <a href="{{ route('admin.staff.index') }}" class="btn-ghost">← Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start;">

    {{-- ── Profile Card ──────────────────────────────────────── --}}
    <div class="admin-card" style="padding:2rem;text-align:center;">
        <div style="width:80px;height:80px;border-radius:50%;background:#006241;color:#fff;
                    font-size:2rem;font-weight:700;display:flex;align-items:center;
                    justify-content:center;margin:0 auto 1rem;">
            {{ strtoupper(substr($staff->name,0,1)) }}
        </div>
        <h2 style="margin:0 0 0.25rem;font-size:1.2rem;">{{ $staff->name }}</h2>
        <p style="margin:0 0 1rem;color:#7f8c8d;font-size:0.9rem;">{{ $staff->email }}</p>

        <div style="display:flex;justify-content:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:1.25rem;">
            <span class="status-pill" style="background:{{ $roleMeta['bg'] }};color:{{ $roleMeta['color'] }};">
                {{ $roleMeta['label'] }}
            </span>
            <span class="status-pill" style="background:{{ $statusMeta['bg'] }};color:{{ $statusMeta['color'] }};">
                {{ $statusMeta['label'] }}
            </span>
        </div>

        {{-- Salary paid this month? --}}
        <div style="padding:0.75rem 1rem;border-radius:10px;margin-bottom:1.25rem;
                    background:{{ $isPaid ? '#d4e9e2' : '#fff8e1' }};
                    border:1.5px solid {{ $isPaid ? '#006241' : '#fbbc05' }};
                    color:{{ $isPaid ? '#006241' : '#b45309' }};
                    font-weight:700;font-size:0.85rem;">
            {{ $isPaid ? '✅ Salary paid for ' . now()->format('F Y') : '⏳ Salary pending for ' . now()->format('F Y') }}
        </div>

        <div class="staff-info-list">
            <div class="staff-info-row">
                <span class="staff-info-label">📞 Phone</span>
                <span>{{ $staff->phone ?: '—' }}</span>
            </div>
            <div class="staff-info-row">
                <span class="staff-info-label">🕐 Shift</span>
                <span>{{ $shiftLabel }}</span>
            </div>
            <div class="staff-info-row">
                <span class="staff-info-label">📍 Store</span>
                <span>{{ $staff->store?->name ?? 'Not assigned' }}</span>
            </div>
            <div class="staff-info-row">
                <span class="staff-info-label">💰 Salary</span>
                <span>${{ number_format($staff->monthly_salary, 2) }}/mo</span>
            </div>
            <div class="staff-info-row">
                <span class="staff-info-label">📅 Joined</span>
                <span>{{ $staff->join_date->format('M j, Y') }}</span>
            </div>
            <div class="staff-info-row">
                <span class="staff-info-label">💵 Total Paid</span>
                <span style="color:#006241;font-weight:700;">${{ number_format($staff->totalPaid(), 2) }}</span>
            </div>
        </div>

        @if($staff->notes)
        <div style="margin-top:1.25rem;padding:0.75rem 1rem;background:#f8faf9;border-radius:8px;text-align:left;font-size:0.88rem;color:#5c6b66;">
            <strong>Notes:</strong> {{ $staff->notes }}
        </div>
        @endif
    </div>

    {{-- ── Payment History ───────────────────────────────────── --}}
    <div class="admin-card">
        <div class="card-header">
            <h2 class="card-title">💳 Payment History</h2>
            <a href="{{ route('admin.salaries.create', ['staff_id' => $staff->id]) }}" class="card-link">Record Payment →</a>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date Paid</th>
                        <th>Paid By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff->salaryPayments as $payment)
                    <tr>
                        <td style="font-weight:600;">{{ $payment->monthLabel() }}</td>
                        <td class="td-total">${{ number_format($payment->amount, 2) }}</td>
                        <td>
                            {{ \App\Models\SalaryPayment::$methods[$payment->payment_method] ?? $payment->payment_method }}
                        </td>
                        <td class="td-date">{{ $payment->payment_date->format('M j, Y') }}</td>
                        <td class="td-date">{{ $payment->paid_by }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.salaries.destroy', $payment) }}"
                                  onsubmit="return confirm('Delete this payment record?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-table btn-table-danger">Void</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="td-empty">No salary payments recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
.staff-info-list { text-align:left; }
.staff-info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.55rem 0;
    border-bottom: 1px solid #f0f4f2;
    font-size: 0.88rem;
}
.staff-info-row:last-child { border-bottom: none; }
.staff-info-label { color: #7f8c8d; }
.btn-table-danger { border-color:#c82014;color:#c82014; }
.btn-table-danger:hover { background:#c82014;color:#fff; }
.status-pill {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 999px;
    padding: 0.25rem 0.7rem;
}
</style>
@endpush
@endsection
