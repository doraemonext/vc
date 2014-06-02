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

Route::get('/', array('uses' => 'HomeController@showHome', 'as' => 'home'));

Route::group(array('prefix' => 'account'), function()
{
    Route::group(array('prefix' => 'login'), function()
    {
        Route::get('/', array('uses' => 'AccountController@showLogin', 'as' => 'login'));
        Route::post('/submit/', array('before' => 'csrf', 'uses' => 'AccountController@submitLogin'));
    });
    Route::group(array('prefix' => 'register'), function()
    {
        Route::get('/', array('uses' => 'AccountController@showRegister', 'as' => 'register'));
        Route::post('/submit/', array('before' => 'csrf', 'uses' => 'AccountController@submitRegister'));
    });
    Route::get('/logout', array('uses' => 'AccountController@showLogout', 'as' => 'logout'));
    // Route::get('/active', array('uses' => 'AccountController@showActive', 'as' => 'active'));
    Route::group(array('prefix' => 'forgotten'), function()
    {
        Route::get('/', array('uses' => 'AccountController@showForgotten', 'as' => 'forgotten'));
        Route::post('/submit/', array('before' => 'csrf', 'uses' => 'AccountController@submitForgotten'));
        Route::get('/reset/', array('uses' => 'AccountController@showForgottenReset', 'as' => 'forgotten_reset'));
        Route::post('/reset/submit/', array('before' => 'csrf', 'uses' => 'AccountController@submitForgottenReset'));
    });
});

Route::group(array('prefix' => 'admin', 'before' => 'Sentry|inGroup:admin'), function()
{
    Route::get('/', array('uses' => 'AdminHomeController@showHome', 'as' => 'admin.home'));
});