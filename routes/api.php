<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    Route::get('/', function () {
        $endpoints = [];

        foreach(Route::getRoutes() as $route) {
            $ignore_routes = [
                'product.photo.stream',
                'equipment.photo.stream',
            ];

            if(
                Str::startsWith($route->uri, 'api/v1/')
                && !in_array($route->getName(), $ignore_routes)
            ) {
                $formattedUri = preg_replace('/\{(\w+)\}/', ':$1', $route->uri);

                $endpoints[] = [
                    'api_url' => url($formattedUri),
                    'method' => $route->methods[0],
                ];
            }
        }

        return response()->json([
            'endpoints' => $endpoints,
        ]);
    });

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::get('/latest/products', [ProductController::class, 'latestProducts']);
    Route::get('/random/products', [ProductController::class, 'randomProducts']);
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

    Route::get('/gallery', [GalleryController::class, 'index']);

    Route::get('/settings', [SettingController::class, 'index']);
});
