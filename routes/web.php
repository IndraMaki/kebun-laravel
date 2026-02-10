<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TanamanController;
use App\Http\Controllers\User\PlantController as UserPlantController;
use App\Http\Controllers\Admin\VarietasController;
use App\Http\Controllers\Admin\NamaController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        $plantCount = \App\Models\Plant::count();
        $categoryCount = \App\Models\Category::count();
        return view('admin.dashboard', compact('plantCount', 'categoryCount'));
    })->name('admin.dashboard');
    Route::resource('kategori', CategoryController::class);
    Route::resource('nama', NamaController::class);
    Route::resource('tanaman', TanamanController::class);
    Route::get('tanaman/{tanaman}/cetak', [TanamanController::class, 'print'])->name('tanaman.print');
    Route::get('api/plants-by-category/{category}', [TanamanController::class, 'plantNamesByCategory']);
    Route::get('api/varieties-by-plant-name/{plantName}', [TanamanController::class, 'varietiesByPlantName']);
    Route::resource('varietas', VarietasController::class);
});

Route::get('tanaman/{tanaman}', [UserPlantController::class, 'show'])->name('user.tanaman.show');
