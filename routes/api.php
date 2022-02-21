<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;

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
