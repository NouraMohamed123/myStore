<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo('App\Models\Store', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(
            'App\Models\Product',
            'order_items'
        )->withPivot(['product_name', 'price', 'quantity', 'options']);
    }

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\OrderAddress');
    }

    public function billingAddress()
    {
        return $this->hasOne('App\Models\OrderAddress')->where(
            'type',
            '=',
            'billing'
        );
    }

    public function shippingAddress()
    {
        return $this->hasOne('App\Models\OrderAddress')->where(
            'type',
            '=',
            'shipping'
        );
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault([
            'name' => 'noura mohamed',
        ]);
    }
    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return strval($number + 1);
        }
        return $year . '0001';
    }

    public function delevery()
    {
        return $this->hasOne('App\Models\Delevery');
    }
}