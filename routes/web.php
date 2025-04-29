<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('index');
});

Route::get('/scan-barcode', function () {
    return view('barcode_scan');
});

Route::get('/result', [ProductController::class, 'show']);
