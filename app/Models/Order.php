<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'items',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'items' => 'array',
        'total' => 'decimal:2',
    ];

    public static $statuses = [
        'pending'   => ['label' => 'Pending',    'color' => '#fbbc05', 'bg' => '#fff8e1'],
        'preparing' => ['label' => 'Preparing',  'color' => '#006241', 'bg' => '#d4e9e2'],
        'ready'     => ['label' => 'Ready',      'color' => '#00754a', 'bg' => '#c8f5e2'],
        'completed' => ['label' => 'Completed',  'color' => '#2b5148', 'bg' => '#d4e9e2'],
        'cancelled' => ['label' => 'Cancelled',  'color' => '#c82014', 'bg' => '#fdecea'],
    ];

    public function getStatusBadgeAttribute(): array
    {
        return self::$statuses[$this->status] ?? ['label' => ucfirst($this->status), 'color' => '#666', 'bg' => '#eee'];
    }

    public function getItemCountAttribute(): int
    {
        return collect($this->items)->sum('qty');
    }
}
