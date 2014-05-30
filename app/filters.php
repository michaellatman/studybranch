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


use StudyBranch\API\v1\TokenController;

App::before(function($request)
{
	//
});

App::after(function($request, $response)
{
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, OPTIONS');
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

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});
Route::filter('cred', function()
{
    if(!\Input::has("access_key")&&!\Input::has("state")&&!\Request::header('Authorization')){
        return Response::make(array('message'=>"Missing credentials"),401,array('WWW-Authenticate'=> 'Basic realm="access_key"'));
    }

    $resp = \StudyBranch\API\v1\TokenController::check();
    if(!$resp){
        return Response::JSON(array('message'=>"Invalid credentials"),400);
    }

});
Route::filter("emailActivated",function(){
    if(count(\StudyBranch\API\v1\Auth::user()->emails) == 0){
        return \Response::json(array("message"=>"You need to activate your account before proceeding!"),401);
    }
});
Route::filter("isInOrg",function($route){
    //Check if in org. If not return message
   if(!\StudyBranch\API\v1\Auth::isInOrg($route->getParameter("orgid"))){
       return \Response::json(array("message"=>"You do not have access to that organization"),403);
   }
    //Finds the organization matching orgid and set it to the global auth object.
    \StudyBranch\API\v1\Auth::setOrganization(\StudyBranch\API\v1\Organization::find(\Route::input("orgid")));
});
Route::filter("isInGroup",function($route){
    //Check if in org. If not return message
    if(!\StudyBranch\API\v1\Auth::isInGroup($route->getParameter("groupid"))){
        return \Response::json(array("message"=>"You do not have access to that group"),403);
    }
    //Finds the organization matching orgid and set it to the global auth object.
    \StudyBranch\API\v1\Auth::setGroup(\StudyBranch\API\v1\Group::find(\Route::input("groupid")));
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
