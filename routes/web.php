<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/dashboard');

Route::redirect('/admin', '/dashboard');

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', fn() => view('dashboard'))->name('dashboard');

    Route::name('dashboard.')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('/{criteria}/settings', [SettingController::class, 'form'])->name('settings.form');
        Route::put('/settings', [SettingController::class, 'save'])->name('settings.save');

        Route::resource('/categories', CategoryController::class);
        Route::resource('/products', ProductController::class);
        Route::resource('/equipments', EquipmentController::class);
        Route::resource('/users', UserController::class);
        Route::resource('/blogs', BlogController::class);
        Route::resource('/banners', BannerController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
