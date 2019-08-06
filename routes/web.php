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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');

Route::post('/2fa', function () {
    return redirect(URL()->previous());
})->name('2fa')->middleware('2fa');

Route::post('/complete-registration', 'Auth\RegisterController@completeRegistration');

Route::name('admin.')->group(function(){
    Route::group(['prefix' => 'admin/'], function () {

        Route::get('/', 'Admin\DashboardController@index')->name('dashboard');

        Route::get('login', 'Admin\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Admin\LoginController@login')->name('login.submit');

        Route::get('logout', 'Admin\LoginController@logout')->name('logout');
    });
});
