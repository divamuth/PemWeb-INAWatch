<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'variation',
        'sale',
        'price',
        'stock',
        'image',
        'is_permanent'
    ];

    protected $casts = [
        'stock' => 'integer',
        'is_permanent' => 'boolean'
    ];

    public static function getStockStats()
    {
        return [
            'sold' => self::sum('sold_quantity'),
            'stock' => self::sum('stock_quantity'),
        ];
    }
}