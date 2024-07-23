<?php

use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\productController;
use App\Http\Controllers\vendorController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\saleController;
use App\Http\Controllers\purchaseController;

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

Route::view('/', 'welcome')->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// theme routes
Route::view('blank', 'webkit')->name('webkit');
Route::view('mazer','mazer')->name('mazer');

Route::group([
    'as' => 'frontend.'
], function () {
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
});

Route::group([
    'middleware' => 'auth'
], function () {
    // Admin Routes
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['auth']
    ], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);

        Route::resource('blogs', AdminBlogController::class);

         // Common routes
    Route::get('/product', [productController::class, 'index'])->name('product.index');
    Route::post('/product', [productController::class, 'store'])->name('product.store');
    Route::get('/product/create', [productController::class, 'create'])->name('product.create');
    Route::get('/product/{id}/edit', [productController::class, 'edit'])->name('product.edit');
    Route::get('/product/{id}/delete', [productController::class, 'destroy'])->name('product.edit');
    Route::put('/product/{id}', [productController::class, 'update'])->name('product.update');

             // Common routes
    Route::get('/vendor', [vendorController::class, 'index'])->name('vendor.index');
    Route::post('/vendor', [vendorController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/create', [vendorController::class, 'create'])->name('vendor.create');
    Route::get('/vendor/{id}/edit', [vendorController::class, 'edit'])->name('vandor.edit');
    Route::get('/vendor/{id}/delete', [vendorController::class, 'destroy'])->name('vendor.destroy');
    Route::put('/vendor/{id}', [vendorController::class, 'update'])->name('vendor.update');


                // Common routes
    Route::get('/customer', [customerController::class, 'index'])->name('customer.index');
    Route::post('/customer', [customerController::class, 'store'])->name('customer.store');
    Route::get('/customer/create', [customerController::class, 'create'])->name('customer.create');
    Route::get('/customer/{id}/edit', [customerController::class, 'edit'])->name('customer.edit');
    Route::get('/customer/{id}/delete', [customerController::class, 'destroy'])->name('customer.destroy');
    Route::put('/customer/{id}', [customerController::class, 'update'])->name('customer.update');

               // Common routes
    Route::get('/sale', [saleController::class, 'index'])->name('sale.index');
    Route::get('/sale/payment/{id}', [saleController::class, 'payment'])->name('sale.payment');
    Route::post('/sale/payment/{id}', [saleController::class, 'createPayment'])->name('create.sale.payment');
    Route::get('/sale/invoice/{id}', [saleController::class, 'invoice'])->name('sale.invoice');
    Route::get('/sale/invoice/{id}/delete', [saleController::class, 'destroy'])->name('sale.invoice.delete');
    Route::get('/sale/create', [saleController::class, 'create'])->name('sale.create');
    Route::get('/sale/balance', [saleController::class, 'balance_list'])->name('sale.balance');
    Route::post('/sale', [saleController::class, 'store'])->name('sale.store');
    Route::get('/sale/{user}/edit', [saleController::class, 'edit'])->name('sale.edit');
    Route::put('/sale/{user}', [saleController::class, 'update'])->name('sale.update');

               // Common routes
    Route::get('/purchase', [purchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/{user}/edit', [purchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase/{user}', [purchaseController::class, 'update'])->name('purchase.update');


    });
                // User routes

                // Common routes
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/{user}/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});
