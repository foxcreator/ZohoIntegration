<?php

use App\Http\Controllers\Auth\ZohoAuthController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/account', [ZohoAuthController::class, 'insertAccount'])->name('account');
Route::get('/user', [ZohoAuthController::class, 'getUser'])->name('user');
Route::get('/zoho', [ZohoAuthController::class, 'getAccessToken'])->name('zoho');
Route::get('/zoho/auth', [ZohoAuthController::class, 'getGrantToken'])->name('zoho.auth');
Route::get('/zoho/callback', [ZohoAuthController::class, 'handleCallback'])->name('zoho.callback');

Route::get('/{any}', [SpaController::class, 'index'])->where('any', '.*');

