<?php

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

Route::post('/deals/create', [\App\Http\Controllers\B2C\DealsController::class, 'store']);
Route::get('/deals/stages', [\App\Http\Controllers\B2C\DealsController::class, 'getStages']);
Route::get('/deals/accounts', [\App\Http\Controllers\B2C\DealsController::class, 'getAccounts']);
Route::get('/deals/owner-id', [\App\Http\Controllers\B2C\DealsController::class, 'getOwnerId']);

Route::post('/accounts/create', [\App\Http\Controllers\B2C\AccountsController::class, 'store']);
