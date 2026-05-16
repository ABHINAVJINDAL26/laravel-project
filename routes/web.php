<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RecipeController;

// Public landing page: list all recipes
Route::get('/', [RecipeController::class, 'index'])->name('home');

// Auth'd dashboard: show recipes for authenticated users
Route::get('/dashboard', [RecipeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // All blog routes are now protected by auth
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');
    Route::post('/blogs/{id}/like', [BlogController::class, 'like'])->name('blogs.like');

    // Recipe creation/editing is only for authenticated users
    Route::get('/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/store', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/edit/{id}', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/update/{id}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/delete/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

// Public recipe routes
Route::get('/recipe/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/sort/{origin}', [RecipeController::class, 'sort'])->name('recipes.sort');

require __DIR__ . '/auth.php';
