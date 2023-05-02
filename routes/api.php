<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->prefix("auth")->group(function () {
    Route::post('logout',[AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth:sanctum')->prefix("products")->group(function () {
    Route::get('list/{limit?}', [ProductController::class, 'index'])->name('product.list');
    Route::post('/', [ProductController::class, 'store'])->name('product.create');
    Route::post('/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/{id}', [ProductController::class, 'show'])->name('product.detail');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::get('/search/{keyword}/{limit?}', [ProductController::class, 'search'])->name('product.search');
});

Route::middleware('auth:sanctum')->prefix("stores")->group(function () {
    Route::get('list/{limit?}', [StoreController::class, 'index'])->name('store.list');
    Route::post('/', [StoreController::class, 'store'])->name('store.create');
    Route::post('/{id}', [StoreController::class, 'update'])->name('store.update');
    Route::get('/{id}', [StoreController::class, 'show'])->name('store.detail');
    Route::delete('/{id}', [StoreController::class, 'destroy'])->name('store.delete');
    Route::get('/search/{keyword}/{limit?}', [StoreController::class, 'search'])->name('store.search');
});
