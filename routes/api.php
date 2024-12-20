<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);

Route::get('/tikets', [TiketController::class, 'index']);
Route::post('/tikets/pesan', [TiketController::class, 'pesan']);
Route::post('/tikets', [TiketController::class, 'store']); // Menambah tiket baru
Route::get('/tikets/{id}', [TiketController::class, 'show']); // Mengambil detail tiket
Route::put('/tikets/{id}', [TiketController::class, 'update']); // Mengubah tiket
Route::delete('/tikets/{id}', [TiketController::class, 'destroy']); // Menghapus tiket

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes yang memerlukan otentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/tikets', [TiketController::class, 'index']);
    Route::post('/tikets/pesan', [TiketController::class, 'pesan']);
    
});

