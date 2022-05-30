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

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'auth'

], function ($router) {

    Route::resource('/products', \App\Http\Controllers\ProductController::class);
    Route::post('logout', [\App\Http\Controllers\LoginController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\LoginController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\LoginController::class, 'me']);
});
Route::get('/products/get_image/{image}', [\App\Http\Controllers\ProductController::class, 'get_image'])->name('get_image');
Route::get('/products/detailsproduct/{id}', [\App\Http\Controllers\ProductController::class, 'getDetailsProduct']);
Route::post('login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('registre', [\App\Http\Controllers\LoginController::class, 'registre']);
