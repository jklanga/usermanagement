<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('permissions', function()
{
    $name = Route::current()->getName();
    $name =  'admin' . ( ! empty($name) ? '.' : '') . $name;
	$url = explode('/',str_replace(URL::to('/'),'',URL::current()));
	if (count($url) >= 3)
		$name = $url[1].'.'.$url[2];
	else $name = $url[1];
	
	if (Sentry::check())
	{
		$user = Sentry::getUser();		
    	if (!$user->hasAccess($name)) 
        	return Redirect::to('/home')->withErrors('You are not authorized to access route '.$name);
    }
	else return Redirect::to('/')->withErrors('You are not logged in.');
});

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});

Route::filter('public_page', function()
{
        if ( ! Sentry::check() && 
        		URL::current() != url('/') && 
        		URL::current() != url('user/login') &&  
				URL::current() != url('user/signup') &&
				URL::current() != url('admin/user/edit'))
        {
           // return Redirect::route('admin.login');
		    return Redirect::to('/')->withErrors('Please log in.');;
        }
});
Route::when('*', 'public_page');


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
