<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    protected $fillable = [
        'staff_id', 'amount', 'payment_month', 'payment_date',
        'payment_method', 'note', 'paid_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount'       => 'decimal:2',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /** Human-readable month label e.g. "July 2026" */
    public function monthLabel(): string
    {
        return \Carbon\Carbon::createFromFormat('Y-m', $this->payment_month)->format('F Y');
    }

    public static array $methods = [
        'cash'            => '💵 Cash',
        'bank_transfer'   => '🏦 Bank Transfer',
        'mobile_banking'  => '📱 Mobile Banking',
    ];
}
