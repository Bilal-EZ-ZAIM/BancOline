<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/token', [AuthController::class, 'getUserFromToken']);
Route::post('/regester', [AuthController::class, 'regester']);
Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/createAcount', [AccountController::class, 'createAcount']);

Route::middleware('auth:sanctum')->post('/deposit', [AccountController::class, 'deposit']);

Route::middleware('auth:sanctum')->post('/transfer', [TransactionController::class, 'transfer']);

Route::middleware('auth:sanctum')->get('/transaction-history', [TransactionController::class, 'transactionHistory']);

Route::middleware('auth:sanctum')->get('/DAdmintransactionHistory', [TransactionController::class, 'DAdmintransactionHistory']);
