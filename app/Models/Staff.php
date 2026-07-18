<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'store_id', 'name', 'email', 'phone', 'role', 'shift',
        'monthly_salary', 'join_date', 'status', 'photo', 'notes',
    ];

    protected $casts = [
        'join_date'       => 'date',
        'monthly_salary'  => 'decimal:2',
    ];

    // ─── Static Lookup Arrays ──────────────────────────────────────────────

    public static array $roles = [
        'barista'    => ['label' => 'Barista',    'color' => '#006241', 'bg' => '#d4e9e2'],
        'cashier'    => ['label' => 'Cashier',    'color' => '#0d6efd', 'bg' => '#cfe2ff'],
        'manager'    => ['label' => 'Manager',    'color' => '#6f42c1', 'bg' => '#e2d9f3'],
        'supervisor' => ['label' => 'Supervisor', 'color' => '#fd7e14', 'bg' => '#ffe5d0'],
        'cleaner'    => ['label' => 'Cleaner',    'color' => '#6c757d', 'bg' => '#e9ecef'],
    ];

    public static array $shifts = [
        'morning'   => '☀️ Morning (6am–2pm)',
        'afternoon' => '🌤 Afternoon (2pm–8pm)',
        'evening'   => '🌙 Evening (4pm–12am)',
        'full_day'  => '🕐 Full Day',
    ];

    public static array $statuses = [
        'active'     => ['label' => 'Active',      'color' => '#006241', 'bg' => '#d4e9e2'],
        'on_leave'   => ['label' => 'On Leave',    'color' => '#b45309', 'bg' => '#fff8e1'],
        'terminated' => ['label' => 'Terminated',  'color' => '#c82014', 'bg' => '#fdecea'],
    ];

    // ─── Relationships ─────────────────────────────────────────────────────

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────

    /** Returns true if salary has been recorded for the given month (default: current month). */
    public function isPaidForMonth(?string $month = null): bool
    {
        $month = $month ?? now()->format('Y-m');
        return $this->salaryPayments()->where('payment_month', $month)->exists();
    }

    /** Total amount paid to this staff member across all time. */
    public function totalPaid(): float
    {
        return (float) $this->salaryPayments()->sum('amount');
    }

    /** Number of months since join_date with no payment recorded. */
    public function unpaidMonthsCount(): int
    {
        $start   = $this->join_date->copy()->startOfMonth();
        $end     = now()->startOfMonth();
        $paid    = $this->salaryPayments()->pluck('payment_month')->toArray();
        $missing = 0;

        while ($start->lte($end)) {
            if (! in_array($start->format('Y-m'), $paid)) {
                $missing++;
            }
            $start->addMonth();
        }

        return $missing;
    }

    /** Pending salary amount (unpaid months × monthly salary). */
    public function pendingAmount(): float
    {
        return $this->unpaidMonthsCount() * (float) $this->monthly_salary;
    }
}
