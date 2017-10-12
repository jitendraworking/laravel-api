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

//for web social login
//Route::get('auth/{provider}', 'SocialAuthController@redirectToProvider')->where('provider','google|github');
//Route::get('auth/{provider}/callback', 'SocialAuthController@handleProviderCallback')->where('provider','google|github');

Route::get('/home', 'HomeController@index')->name('home');
