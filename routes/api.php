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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::get('auth/{provider}', 'SocialAuthController@redirectToProvider')->where('provider','google|github');
Route::get('auth/{provider}/callback', 'SocialAuthController@handleProviderCallback')->where('provider','google|github');
Route::group(['middleware' => 'jwt-auth'], function () {
	Route::middleware(['has_role:manager'])->group(function () {
		Route::get('getPost', 'postController@getPost');
	});
	Route::get('logout', 'AuthController@logout');
	Route::post('admin/createRole', 'AdminController@createRole');
	Route::post('admin/createPermission', 'AdminController@createPermission');
	Route::post('admin/addPermission', 'AdminController@addPermission');
	Route::post('admin/addRole', 'AdminController@addRole');
	Route::post('admin/addPermissionToRole', 'AdminController@addPermissionToRole');
});

