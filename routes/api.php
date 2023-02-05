<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!W
|
*/
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function(){

    Route::apiResource('productos', ProductoController::class);
    Route::put('/set_like/{producto}', [ProductoController::class, 'setLike'])->name('set_like');
    Route::put('/set_dislike/{producto}', [ProductoController::class, 'setDisLike'])->name('set_dislike');
    Route::put('set_imagen/{producto}', [ProductoController::class, 'setImagen'])->name('set_imagen');
    Route::post('logout', [UserController::class, 'logout']);
    
});



