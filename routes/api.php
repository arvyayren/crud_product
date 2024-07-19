<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::prefix('v1')->group(function () {
    Route::get('/product', [ProductController::class, 'list']);
    Route::post('/product/create', [ProductController::class, 'create']);
    Route::post('/product/update', [ProductController::class, 'update']);
    Route::post('/product/delete', [ProductController::class, 'delete']);
});