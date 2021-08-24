<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['cors'])->group(function () {
    
    //user側
    Route::get('test1', [TestController::class, 'test1']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('user/register', [AuthController::class, 'register']);
    Route::post('user/temporary/register', [AuthController::class, 'temporaryRegister']);
    
    //shop側
    Route::post('shop/login', [ShopAuthController::class, 'login'])->name('login');
    Route::post('shop/register', [ShopAuthController::class, 'register']);
       
    // Route::prefix('users')->group(function(){   
    //     Route::get('me', [AuthController::class, 'me']);
    // }); 
});

// Route::prefix('shop')->group(function(){   
//     Route::post('login', [ShopAuthController::class, 'login'])->name('login');
//     Route::post('logout', [ShopAuthController::class, 'logout']);
//     Route::post('refresh', [ShopAuthController::class, 'refresh']);
//     Route::get('me', [ShopAuthController::class, 'me']);
// });
