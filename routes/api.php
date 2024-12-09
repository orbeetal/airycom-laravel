<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\EquipmentController;
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
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::get('/latest/products', [ProductController::class, 'latestProducts']);
    Route::get('/{category}/products', [ProductController::class, 'categoryProducts']);
    Route::get('/products/{id}/photos/{serial?}.jpeg', [ProductController::class, 'streamPhoto'])->name('product.photo.stream');
    
    Route::get('/equipments', [EquipmentController::class, 'index']);
    Route::get('/equipments/{slug}', [EquipmentController::class, 'show']);
    Route::get('/latest/equipments', [EquipmentController::class, 'latestEquipments']);
    Route::get('/{category}/equipments', [EquipmentController::class, 'categoryEquipments']);
    Route::get('/equipments/{id}/photos/{serial?}.jpeg', [EquipmentController::class, 'streamPhoto'])->name('equipment.photo.stream');
    Route::get('/products/{id}/photos/{serial?}.jpeg', [ProductController::class, 'streamPhoto'])->name('product.photo.stream');

    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{slug}', [BlogController::class, 'show']);
});
