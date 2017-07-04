<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::post('user/login', array('uses' => 'UserController@login'));
Route::get('/', array('uses' => 'HomeController@login'));
Route::get('/home', array('uses' => 'HomeController@home'));
Route::match(array('GET'), 'user/signup', array('as' => 'admin.user.edit', 'uses' => 'UserController@showEditUser'));
Route::match(array('GET','POST'),'admin/user/edit', array('as' => 'admin.user.edit', 'uses' => 'UserController@showEditUser'));
Route::group(array('before' => 'permissions'), function()
{
	Route::match(array('GET','POST'), 'admin/users', array('as' => 'admin.users', 'uses' => 'UserController@listUsers'));
	
	Route::get('admin/activitylogs', array('uses' => 'AdminController@listActivityLogs'));
	Route::match(array('GET'),'admin/viewlog', array('as' => 'admin.viewlog', 'uses' => 'AdminController@getViewLog'));
});
Route::controller('user', 'UserController');

