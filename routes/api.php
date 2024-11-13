<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/products/{id}/photo/{serial?}', [ProductController::class, 'streamPhoto'])->name('product.photo.stream');

    Route::get('{category}/products', [ProductController::class, 'categoryProducts']);

    Route::get('/products', [ProductController::class, 'index']);
});
