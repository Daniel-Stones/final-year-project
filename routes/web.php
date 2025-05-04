<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavouriteController;

Route::get('/', function () {
    return view('index');
});

Route::get('/result', [ProductController::class, 'show']);

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/favourites', [FavouriteController::class, 'store'])->name('favourites.store');
Route::delete('/favourites', [FavouriteController::class, 'destroy'])->name('favourites.destroy');
Route::get('/favourites', [FavouriteController::class, 'favourites'])->name('favourites.index')->middleware('auth');