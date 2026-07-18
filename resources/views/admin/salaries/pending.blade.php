@extends('admin.layout')
@section('title', 'Pending Salaries')
@section('breadcrumb', 'Pending Salaries')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">⏳ Pending Salaries</h1>
        <p class="page-subtitle">Active staff members who have not been paid for
            <strong>{{ \Carbon\Carbon::createFromFormat('Y-m', $currentMonth)->format('F Y') }}</strong>.
        </p>
    </div>
    <div class="page-title-actions">
        <a href="{{ route('admin.salaries.index') }}" class="btn-secondary">← All Payments</a>
        <a href="{{ route('admin.salaries.create') }}" class="btn-primary">+ Record Payment</a>
    </div>
</div>

@if($pendingStaff->isEmpty())
    <div class="admin-card" style="padding:3rem;text-align:center;">
        <div style="font-size:3rem;margin-bottom:0.75rem;">🎉</div>
        <h2 style="color:#006241;margin:0 0 0.5rem;">All salaries are paid!</h2>
        <p style="color:#5c6b66;">Every active staff member has been paid for {{ \Carbon\Carbon::createFromFormat('Y-m', $currentMonth)->format('F Y') }}.</p>
    </div>
@else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem;">
        @foreach($pendingStaff as $member)
        @php
            $roleMeta = \App\Models\Staff::$roles[$member->role] ?? ['label'=>$member->role,'bg'=>'#eee','color'=>'#333'];
        @endphp
        <div class="pending-staff-card">
            <div class="pending-staff-header">
                <div class="pending-avatar">{{ strtoupper(substr($member->name,0,1)) }}</div>
                <div>
                    <div class="pending-name">{{ $member->name }}</div>
                    <span class="status-pill" style="background:{{ $roleMeta['bg'] }};color:{{ $roleMeta['color'] }};">
                        {{ $roleMeta['label'] }}
                    </span>
                </div>
            </div>

            <div class="pending-detail-row">
                <span>📍 Store</span>
                <span>{{ $member->store?->name ?? 'Not assigned' }}</span>
            </div>
            <div class="pending-detail-row">
                <span>💰 Monthly Salary</span>
                <span style="font-weight:700;">${{ number_format($member->monthly_salary, 2) }}</span>
            </div>
            <div class="pending-detail-row">
                <span>📅 Joined</span>
                <span>{{ $member->join_date->format('M Y') }}</span>
            </div>

            <div class="pending-overdue-badge">
                ⚠️ Salary overdue for {{ \Carbon\Carbon::createFromFormat('Y-m', $currentMonth)->format('F Y') }}
            </div>

            <a href="{{ route('admin.salaries.create', ['staff_id' => $member->id]) }}"
               class="btn-pay-now">
                💵 Pay Now
            </a>
        </div>
        @endforeach
    </div>
@endif

@push('styles')
<style>
.pending-staff-card {
    background: #fff;
    border: 2px solid #fdecea;
    border-radius: 14px;
    padding: 1.5rem;
    box-shadow: 0 4px 16px rgba(200,32,20,0.06);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    transition: box-shadow 0.2s;
}
.pending-staff-card:hover { box-shadow: 0 8px 24px rgba(200,32,20,0.12); }
.pending-staff-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}
.pending-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #c82014, #e53935);
    color: #fff;
    font-size: 1.4rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pending-name { font-size: 1rem; font-weight: 700; color: #1E3932; margin-bottom: 0.25rem; }
.pending-detail-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #5c6b66;
    padding: 0.3rem 0;
    border-bottom: 1px solid #f8f0f0;
}
.pending-detail-row:last-of-type { border-bottom: none; }
.pending-overdue-badge {
    background: #fff8e1;
    border: 1.5px solid #fbbc05;
    color: #b45309;
    font-size: 0.8rem;
    font-weight: 700;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    text-align: center;
}
.btn-pay-now {
    display: block;
    text-align: center;
    background: linear-gradient(135deg, #006241, #00754a);
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    border-radius: 8px;
    padding: 0.75rem;
    text-decoration: none;
    transition: opacity 0.2s;
    margin-top: 0.25rem;
}
.btn-pay-now:hover { opacity: 0.88; }
.status-pill {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    border-radius: 999px;
    padding: 0.2rem 0.6rem;
}
</style>
@endpush
@endsection
