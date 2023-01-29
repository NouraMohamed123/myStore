<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//use  Dashboard\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\front\CartController;

use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\ProductController;
use App\Http\Controllers\front\CheckOutController;
use App\Http\Controllers\Dashboard\CategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{product::slug}', [
    ProductController::class,
    'show',
])->name('products.show');
Route::resource('cart', CartController::class);
Route::get('checkout', [CheckOutController::class, 'create'])->name('checkout');
Route::post('checkout', [CheckOutController::class, 'store']);

Route::get('/orders/{order}', [OrderController::class, 'show']);