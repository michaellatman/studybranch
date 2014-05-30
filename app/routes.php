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

Route::get('/', 'HomeController@showWelcome');


Route::get('users', function()
{
    return View::make('users/users');
});

Route::get('app', function()
{

    return View::make('app/index');
});

Route::group(array('prefix' => '/api/1/'), function()
{
    Route::get('/login', 'StudyBranch\API\v1\TokenController@get');
    Route::get('/login/google', 'StudyBranch\API\v1\TokenController@login_with_google');
    Route::get('/login/google/callback', 'StudyBranch\API\v1\TokenController@login_with_google_callback');
    Route::post('register', 'StudyBranch\API\v1\UserController@post_register');
    Route::group(array('prefix' => '/account/'), function()
    {
        Route::post('add_email', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@post_add_email'));
        Route::get('email_verify/{key}', 'StudyBranch\API\v1\UserController@get_email_verify');
        Route::get('info', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@get_account_info'));
        Route::get('test', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@test'));
        Route::get('phone', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@get_account_phone'));
        Route::get('link/google', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@get_link_google'));
        Route::get('link/google/callback', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@get_link_google_callback'));
        Route::post('change_password', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@post_change_password'));
        Route::post('change_bio', array('before'=>'cred','uses'=>'StudyBranch\API\v1\UserController@post_change_bio'));
    });
    Route::resource('organizations', 'StudyBranch\API\v1\OrganizationController');
    Route::resource('news', 'StudyBranch\API\v1\AnnouncementController');
    Route::resource('sections', 'StudyBranch\API\v1\SectionController');
    Route::resource('assignments', 'StudyBranch\API\v1\AssignmentController');
    Route::resource('tracks', 'StudyBranch\API\v1\TrackController');



    //Below is legacy API's
    Route::group(array('prefix' => '/group/{groupid}/'), function()
    {
        Route::get('', array('before'=>'cred|isInGroup','uses'=>'StudyBranch\API\v1\GroupController@get_group'));
        Route::get('users', array('before'=>'cred|isInGroup','uses'=>'StudyBranch\API\v1\GroupController@get_user_list'));
    });


    Route::group(array('prefix' => '/task/', 'before'=>'cred'), function()
    {
        Route::options('*', 'StudyBranch\API\v1\TaskController@options');
        Route::post('', 'StudyBranch\API\v1\TaskController@post_create_task');
        Route::get('', 'StudyBranch\API\v1\TaskController@get_list_task');
        Route::get('finished', 'StudyBranch\API\v1\TaskController@get_finished_tasks');
        Route::delete('finished', 'StudyBranch\API\v1\TaskController@delete_finished_tasks');
        Route::get('{id}', 'StudyBranch\API\v1\TaskController@get_task');
        Route::delete('{id}', 'StudyBranch\API\v1\TaskController@delete_task');
        Route::put('{id}/finish','StudyBranch\API\v1\TaskController@post_task_complete');
    });

});
