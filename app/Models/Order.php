<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price', 
        'order_date',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_price' => 'decimal:2', 
    ];

    // Relationship with OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Calculate total price from order items
    public function getTotalPriceAttribute()
    {
        // If total_price column exists, return it
        if (isset($this->attributes['total_price'])) {
            return $this->attributes['total_price'];
        }
        
        // Otherwise, calculate from items
        return $this->items->sum('total_price');
    }

    // Alternative method to get total price
    public function calculateTotal()
    {
        return $this->items->sum('total_price');
    }

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