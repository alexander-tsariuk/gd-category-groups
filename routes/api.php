<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'backend'], function () {
    Route::get('getList', [\App\Http\Controllers\BackendController::class, 'getList']);
    Route::get('getOne/{id}', [\App\Http\Controllers\BackendController::class, 'getOne']);
    Route::post('create', [\App\Http\Controllers\BackendController::class, 'createItem']);
    Route::put('update/{id}', [\App\Http\Controllers\BackendController::class, 'updateItem']);
    Route::delete('delete/{id}', [\App\Http\Controllers\BackendController::class, 'deleteItem']);
});

Route::group(['prefix' => 'frontend'], function (){
    //...
});
