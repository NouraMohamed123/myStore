<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\Cart\CartRepositry;

class Cart extends Facade
{
 protected static function getFacadeAccessor()
    {
        return CartRepositry::class;
    }
}