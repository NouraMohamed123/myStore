<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//use  Dashboard\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\front\OrderController;

use App\Http\Controllers\front\PaymentController;
use App\Http\Controllers\front\CurrencyController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\RoleController;

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

//Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name(
        'dashboard'
    );

    Route::resource('categories', CategoryController::class);

    Route::get(
        '/categories/trash',
        'App\Http\Controllers\Dashboard\CategoryController@trash'
    )->name('dashboard.categories.trash');

    Route::put('categories/{category}/restore', [
        CategoryController::class,
        'restore',
    ])->name('dashboard.categories.restore');

    Route::delete('categories/{category}/force-delete', [
        CategoryController::class,
        'forceDelete',
    ])->name('dashboard.categories.forceDelete');

    Route::resource('products', ProductController::class);
    ///////////role

    Route::resource('roles', RoleController::class);
    ////////////
    Route::get(
        '/profile',
        'App\Http\Controllers\Dashboard\ProfileController@edit'
    )->name('dashboard.profile.edit');

    Route::patch(
        'profile',
        'App\Http\Controllers\Dashboard\ProfileController@update'
    )->name('dashboard.profile.update');

    Route::post('currency', [CurrencyController::class, 'store'])->name(
        'currency.store'
    );

    Route::get('orders/{order}/pay', [
        PaymentController::class,
        'create',
    ])->name('orders.payments.create');

    Route::post('orders/{order}/stripe/payment', [
        PaymentController::class,
        'createStripePaymentIntent',
    ])->name('stripe.paymentIntent.create');

    Route::get('orders/{order}/stripe/payment', [
        PaymentController::class,
        'confirm',
    ])->name('stripe.return');
});

// require __DIR__ . '/auth.php';