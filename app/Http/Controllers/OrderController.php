<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Sample data - nanti ganti dengan data dari database
        $orders = [
            [
                'id' => '3456799827ytg',
                'customer' => 'Diva',
                'products' => [
                    [
                        'name' => 'INA Watch Jam Tangan Kayu Jati Seri Rara Ngigel',
                        'variant' => 'L, Abu Polos',
                        'payment_method' => 'QRIS',
                        'price' => 214900,
                        'quantity' => 1,
                        'status' => 'delivered',
                        'delivery_number' => '3789261789198019928'
                    ]
                ]
            ]
        ];

        return view('seller.order', compact('orders'));
    }
}