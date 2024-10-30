<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
Route::get('/', action: [PublicController::class, 'show']);

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', [CategoryController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/admin',      [CategoryController::class, 'index'])->middleware(middleware: ['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');





    Route::prefix('admin/category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index'); // Get all categories and display in Inertia component
                Route::get('/test', [CategoryController::class, 'test'])->name('categories.test'); // Delete a menu
Route::get('create', [CategoryController::class, 'create'])->name('categories.create'); // Display form to create a new menu
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store'); // Create a new menu
        Route::get('{id}', [CategoryController::class, 'show'])->name('categories.show'); // Display a specific menu
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); // Display form to edit a menu
        Route::post('/{id}', [CategoryController::class, 'update'])->name('categories.update'); // Update a menu
        Route::delete('{id}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Delete a menu
    });
    Route::prefix('admin/product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index'); // Get all categories and display in Inertia component
        Route::get('create', [ProductController::class, 'create'])->name('products.create'); // Display form to create a new menu
        Route::post('/', [ProductController::class, 'store'])->name('products.store'); // Create a new menu
        Route::get('{id}', [ProductController::class, 'show'])->name('products.show'); // Display a specific menu
        Route::get('{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // Display form to edit a menu
        Route::post('/{id}', [ProductController::class, 'update'])->name('products.update'); // Update a menu
        Route::delete('{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // Delete a menu
    });


});
require __DIR__.'/auth.php';
Route::get('/{category}/{product}', [PublicProductController::class, 'show'])->name('category.product');

Route::get('/{category}', [PublicCategoryController::class, 'show'])->name('category');

