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

use Illuminate\Support\Facades\Route;

Route::middleware(['fw-only-whitelisted'])->group(function () {
    Route::get('login/linkedin', 'Auth\LoginController@redirectToProvider')->name('login');
    Route::get('login/linkedin/callback', 'Auth\LoginController@handleProviderCallback');

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('delete-logout', 'Auth\LoginController@deleteAndLogout')->name('delete-logout');

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/user', 'UserController@list');
    Route::get('/account', 'ProfileController@showForm')->name('account');
    Route::get('/profile', 'ProfileController@showForm')->name('profile');
    Route::post('/profile', 'ProfileController@update')->name('profile.update');
});
