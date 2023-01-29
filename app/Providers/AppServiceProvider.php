<?php

namespace App\Providers;

use App\services\CurrencyConverter;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('currency.converter', function () {
            return new CurrencyConverter(
                config('services.currency_converter.api_key')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $local = request('local', Cookie::get('locale'));
        //    App::setlocale($local);
        //  App::currentLocal()
        // Cookie::queue('locale', $local, 60 * 20 * 365);
        Paginator::useBootstrap();
    }
}