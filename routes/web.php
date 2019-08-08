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

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('login/linkedin', 'Auth\LoginController@redirectToProvider')->name('sign-in');
Route::get('login/linkedin/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('delete-logout', 'Auth\LoginController@deleteAndLogout')->name('delete-logout');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/user', function () {
    return UserResource::collection(User::all());
});
