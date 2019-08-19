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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('users/me', 'API\UserController@me')->name('me');
Route::resource('users', 'API\UserController', ['only' => ['update']]);

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
