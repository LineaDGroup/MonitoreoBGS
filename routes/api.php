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

Route::post('auth/login', 'ApiTokenController@login');
// Route::get('/estadisticas', 'ApiTokenController@estadisticas');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('/usuarios', 'ApiTokenController@usuarios');
    Route::post('/estadisticas', 'ApiTokenController@estadisticas');
});

Route::get('/medirFallas','ApiTokenController@medirFallas');
