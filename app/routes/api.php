<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {

    Route::get('articulos', 'ArticuloController@search')->name('general_search');

    Route::group(['prefix' => '/notificaciones'], function () {
        Route::get('/all','NotificacionController@getAll')->name('notificaciones_all');
        Route::get('/read/{id}','NotificacionController@read')->name('notificaciones_read');
    });

});

