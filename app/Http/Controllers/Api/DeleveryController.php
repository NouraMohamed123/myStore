<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Delevery;

class DeleveryController extends Controller
{
    public function update(Request $request, Delevery $delivery)
    {
        $request->validate([
            'lng' => ['required', 'numeric'],
            'lat' => ['required', 'numeric'],
        ]);

        $delivery->update([
            'current_location' => DB::raw(
                "POINT({$request->lng}, {$request->lat})"
            ),
        ]);

        return $delivery;
    }
}