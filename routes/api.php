<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::prefix('categories')
    ->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('{category}', [CategoryController::class, 'delete'])->name('categories.delete');
    });

Route::prefix('customers')
    ->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::put('{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('{customer}', [CustomerController::class, 'delete'])->name('customers.delete');
    });

Route::prefix('products')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('{product}', [ProductController::class, 'show'])->name('products.show');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::put('{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('{product}', [ProductController::class, 'delete'])->name('products.delete');
    });

Route::prefix('orders')
    ->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    });