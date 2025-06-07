<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public static function getOrderStats()
    {
        return [
            'finished' => self::where('status', 'finished')->count(),
            'in_packing' => self::where('status', 'in_packing')->count(),
            'delivered' => self::where('status', 'delivered')->count(),
            'cancelled' => self::where('status', 'cancelled')->count(),
        ];
    }
}