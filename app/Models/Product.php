<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static function getStockStats()
    {
        return [
            'sold' => self::sum('sold'),
            'stock' => self::sum('stock'),
        ];
    }
}