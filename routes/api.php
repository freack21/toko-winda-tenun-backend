<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\ImageController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('transactions', [TransactionController::class, 'all']);
    Route::post('checkout', [TransactionController::class, 'checkout']);
});


Route::get('products', [ProductController::class, 'all']);
Route::get('categories', [ProductCategoryController::class, 'all']);

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::post('/save-image', [ImageController::class, 'store']);
