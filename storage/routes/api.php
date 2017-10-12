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

Route::post('auth/register', 'authController@register');
Route::post('auth/login', 'authController@login');
Route::group(['middleware' => 'jwt-auth'], function () {
	Route::middleware(['role:manager'])->group(function () {
		Route::get('getPost', 'postController@getPost');
	});
	Route::get('logout', 'authController@logout');
	Route::post('admin/createRole', 'adminController@createRole');
	Route::post('admin/createPermission', 'adminController@createPermission');
	Route::post('admin/addPermission', 'adminController@addPermission');
	Route::post('admin/addRole', 'adminController@addRole');
	Route::post('admin/addPermissionToRole', 'adminController@addPermissionToRole');
});

