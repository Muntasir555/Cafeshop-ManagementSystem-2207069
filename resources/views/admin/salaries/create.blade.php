@extends('admin.layout')
@section('title', 'Record Salary Payment')
@section('breadcrumb', 'Record Payment')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">💵 Record Salary Payment</h1>
        <p class="page-subtitle">Log a salary payment for a staff member.</p>
    </div>
    <a href="{{ route('admin.salaries.index') }}" class="btn-secondary">← Back to Payments</a>
</div>

<div class="admin-card form-card" style="max-width:680px;">
    <form method="POST" action="{{ route('admin.salaries.store') }}">
        @csrf

        @if($errors->any())
        <div class="form-errors">
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="form-grid">

            {{-- Staff Member --}}
            <div class="form-group form-full">
                <label class="form-label" for="staff_id">Staff Member <span class="required">*</span></label>
                <select name="staff_id" id="staff_id"
                        class="form-select @error('staff_id') is-error @enderror"
                        required onchange="fillSalary(this)">
                    <option value="">Select staff member…</option>
                    @foreach($staffList as $member)
                        <option value="{{ $member->id }}"
                                data-salary="{{ $member->monthly_salary }}"
                            {{ old('staff_id', $selectedStaff?->id) == $member->id ? 'selected' : '' }}>
                            {{ $member->name }} — {{ ucfirst($member->role) }}
                            (${{ number_format($member->monthly_salary, 2) }}/mo)
                        </option>
                    @endforeach
                </select>
                @error('staff_id')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Payment Month --}}
            <div class="form-group">
                <label class="form-label" for="payment_month">
                    Month Paying For <span class="required">*</span>
                </label>
                <input type="month" name="payment_month" id="payment_month"
                       class="form-input @error('payment_month') is-error @enderror"
                       value="{{ old('payment_month', $currentMonth) }}" required>
                @error('payment_month')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Payment Date --}}
            <div class="form-group">
                <label class="form-label" for="payment_date">
                    Date Paid <span class="required">*</span>
                </label>
                <input type="date" name="payment_date" id="payment_date"
                       class="form-input @error('payment_date') is-error @enderror"
                       value="{{ old('payment_date', now()->toDateString()) }}" required>
                @error('payment_date')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Amount --}}
            <div class="form-group">
                <label class="form-label" for="amount">
                    Amount ($) <span class="required">*</span>
                </label>
                <input type="number" name="amount" id="amount"
                       class="form-input @error('amount') is-error @enderror"
                       value="{{ old('amount', $selectedStaff?->monthly_salary) }}"
                       required step="0.01" min="0" placeholder="0.00">
                <p class="form-hint">Auto-filled from monthly salary. Adjust if needed.</p>
                @error('amount')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Payment Method --}}
            <div class="form-group">
                <label class="form-label" for="payment_method">
                    Payment Method <span class="required">*</span>
                </label>
                <select name="payment_method" id="payment_method"
                        class="form-select @error('payment_method') is-error @enderror" required>
                    <option value="">Select method…</option>
                    @foreach($methods as $key => $label)
                        <option value="{{ $key }}" {{ old('payment_method') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Note --}}
            <div class="form-group form-full">
                <label class="form-label" for="note">Note (optional)</label>
                <textarea name="note" id="note" class="form-textarea" rows="2"
                          placeholder="e.g. Bonus included, advance deducted, etc.">{{ old('note') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">💾 Record Payment</button>
            <a href="{{ route('admin.salaries.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function fillSalary(select) {
    const option = select.options[select.selectedIndex];
    const salary = option.dataset.salary;
    if (salary) {
        document.getElementById('amount').value = parseFloat(salary).toFixed(2);
    }
}
// On page load — if staff pre-selected, fill salary immediately
document.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('staff_id');
    if (sel.value) fillSalary(sel);
});
</script>
@endpush
@endsection
