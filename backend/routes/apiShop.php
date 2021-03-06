<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\ShopAuthController;

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


Route::middleware(['cors'])->group(function () {
    //shopUser側
    
    Route::get('test1', [TestController::class, 'test1']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [ShopAuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});
