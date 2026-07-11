<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'calories',
        'badge',
        'image',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public static $categories = [
        'Cold Drinks',
        'Hot Drinks',
        'Frappuccino',
        'Teas & Chai',
        'Bakery',
        'Food & Snacks',
        'Merchandise',
        'Gift Cards',
    ];

    public static $badges = [
        'Fan Fave',
        'New',
        'Trending',
        'Limited',
        'Seasonal',
    ];
}
