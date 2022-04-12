<?php

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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'categories'], function () {

        Route::group(['prefix' => 'groups'], function () {
            Route::group(['prefix' => 'backend'], function () {
                Route::get('getList', [\App\Http\Controllers\Groups\BackendController::class, 'getList']);
                Route::get('getOne/{id}', [\App\Http\Controllers\Groups\BackendController::class, 'getOne']);
                Route::post('create', [\App\Http\Controllers\Groups\BackendController::class, 'createItem']);
                Route::put('update/{id}', [\App\Http\Controllers\Groups\BackendController::class, 'updateItem']);
                Route::delete('delete/{id}', [\App\Http\Controllers\Groups\BackendController::class, 'deleteItem']);
            });

            Route::group(['prefix' => 'frontend'], function () {
                Route::get('getMenu', [\App\Http\Controllers\Groups\FrontendController::class, 'getMenu']);
            });
        });


        Route::group(['prefix' => 'items'], function () {
            Route::group(['prefix' => 'backend'], function () {

                Route::get('getList', [\App\Http\Controllers\Items\BackendController::class, 'getList']);
                Route::get('getOne/{id}', [\App\Http\Controllers\Items\BackendController::class, 'getOne']);
                Route::post('create', [\App\Http\Controllers\Items\BackendController::class, 'createItem']);
                Route::put('update/{id}', [\App\Http\Controllers\Items\BackendController::class, 'updateItem']);
                Route::delete('delete/{id}', [\App\Http\Controllers\Items\BackendController::class, 'deleteItem']);
            });

            Route::group(['prefix' => 'frontend'], function () {
                Route::get('getOne/{id}', [\App\Http\Controllers\Items\FrontendController::class, 'getOne']);
            });
        });


    });
});

