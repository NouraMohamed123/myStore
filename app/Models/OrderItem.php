<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Pivot
{
    use HasFactory;
    protected $table = 'order_items';
    public $timestamps = false;
    public $incrementing = true;

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withDefault([
            'name' => $this->product_name,
        ]);
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}