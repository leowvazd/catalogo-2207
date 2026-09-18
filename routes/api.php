<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/items/{variant}', [CartController::class, 'add']);
Route::put('/cart/items/{variant}', [CartController::class, 'update']);
Route::delete('/cart/items/{variant}', [CartController::class, 'remove']);
Route::delete('/cart', [CartController::class, 'clear']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
