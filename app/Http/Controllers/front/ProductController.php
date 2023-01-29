<?php

namespace App\Http\Controllers\front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('front.products.show', compact('product'));
    }
}