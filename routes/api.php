<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;

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
Route::resource('/products', \App\Http\Controllers\ProductController::class);
Route::get('/products/detailsproduct/{id}', [\App\Http\Controllers\ProductController::class, 'getDetailsProduct']);
Route::resource('/authentication', \App\Http\Controllers\LoginController::class);
Route::post('/authentication/validate_user', [\App\Http\Controllers\LoginController::class, 'validateUser']);


