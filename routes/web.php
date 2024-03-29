<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => ['web', '\crocodicstudio\crudbooster\middlewares\CBBackend'],
    'prefix' => config('crudbooster.ADMIN_PATH')
], function () {
    Route::get('apitoken','ApiTokenController@getToken');
    Route::get('bio_camara/{id}/reset','ApiTokenController@resetCamara');
});