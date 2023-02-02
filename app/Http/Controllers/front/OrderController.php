<?php

namespace App\Http\Controllers\front;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $delevery = $order
            ->delevery()
            ->select([
                'id',
                'order_id',
                'status',
                DB::raw('ST_Y(current_location) AS lat'),
                DB::raw('ST_X(current_location) AS lng'),
            ])
            ->first();

        return view('front.orders.show', [
            'order' => $order,
            'delivery' => $delevery,
        ]);
    }
}