<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Cart\CartRepositry;
use App\Repositories\Cart\CartModelRepositry;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('cart',function(){
        //     return new CartModelRepositry();
        // });
         $this->app->bind(CartRepositry::class,function(){
            return new CartModelRepositry();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}