<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
* Set first page to be the login page
*/
Route::get('/', function () {
    return view('auth.login');
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () {
   
    //The login route calles the login function from the Authcontroller 
    Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@login']);
    //The handlelogin route calles the handlelogin function from the authcontroller to get the requested login details  
    Route::post('/handleLogin', ['as' => 'handleLogin', 'uses' => 'AuthController@handleLogin']);
    //The users home page route call the home function from the userscontroller
    Route::get('/home', ['middleware' => 'auth', 'as' => 'home', 'uses' => 'UsersController@home']);
    //The users logout action route call the logout function from the authcontroller 
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    //The forgotpassword action route to call forgot password function from auhtcontroller 
    Route::get('/forgotpassword', ['as' => 'forgotpassword', 'uses' => 'AuthController@forgotpassword']);
    //The hanleforgot route takes the requested email to send the reset link 
    Route::post('/handleForgot', ['as' => 'handleForgot', 'uses' => 'AuthController@handleForgot']);
    //updatepassword route takes the updates password and validate the requested token
    Route::post('/updatePassword', ['as' => 'updatePassword', 'uses' => 'AuthController@updatePassword']);
    Route::resource('users', 'UsersController');
    //the confirmregistiration route take the requested email and token to confirm the account
    Route::get('/users/confirmRegistiration/email/{email}/confirm_token/{confirm_token}',['uses' => 'UsersController@confirmRegister']);
    //the passwordreset route take the requested email and reset token to update the password
    Route::get('/auth/passwordReset/email/{email}/reset_token/{reset_token}',['uses' => 'AuthController@passwordReset']);
    
    
});