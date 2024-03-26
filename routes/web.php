<?php

use App\Http\Controllers\Auth\ZohoAuthController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

Route::get('/zoho/token', [ZohoAuthController::class, 'getAccessToken'])->name('zoho.token');
Route::get('/zoho/auth', [ZohoAuthController::class, 'getGrantToken'])->name('zoho.auth');
Route::get('/zoho/callback', [ZohoAuthController::class, 'handleCallback'])->name('zoho.callback');

Route::get('/{any}', [SpaController::class, 'index'])->where('any', '.*');

