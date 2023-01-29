<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\services\CurrencyConverter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function store(Request $request)
    {
        $currencyCode = $request->input('currency_code');

        $baseCurrencyCode = config('app.currency');

        $rates = Cache::get('currency_rates', []);

        if (!isset($rates[$currencyCode])) {
            $converter = new CurrencyConverter(
                config('services.currency_converter.api_key')
            );
            $rate = $converter->convert($baseCurrencyCode, $currencyCode);
            $rates[$currencyCode] = $rate;
            Cache::put('currency_rates', $rates, now()->addMinutes(60));
        }

        Session::put('currency_code', $currencyCode);

        return redirect()->back();
    }
}