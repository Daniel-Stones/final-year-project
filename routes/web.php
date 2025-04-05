<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/scan-barcode', function () {
    return view('barcode_scan');
});
