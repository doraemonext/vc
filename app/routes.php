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

    // 投资方管理
    Route::group(array('prefix' => 'vc'), function()
    {
        Route::get('/', array('uses' => 'AdminVcController@showVc', 'as' => 'admin.vc'));
        Route::group(array('prefix' => 'new'), function()
        {
            Route::get('/', array('uses' => 'AdminVcController@showNew', 'as' => 'admin.vc.new'));
            Route::post('/submit/', array('before' => 'csrf', 'uses' => 'AdminVcController@submitNew'));
        });
        Route::group(array('prefix' => 'edit'), function()
        {
            Route::get('/{id?}/', array('uses' => 'AdminVcController@showEdit', 'as' => 'admin.vc.edit'));
            Route::post('/{id?}/submit/', array('uses' => 'AdminVcController@submitEdit'));
        });
        Route::group(array('prefix' => 'ajax'), function()
        {
            Route::get('/delete/{id?}', array('uses' => 'AdminVcController@ajaxDeleteVc', 'as' => 'admin.vc.ajax.delete'));
        });
    });

    // 项目管理
    Route::group(array('prefix' => 'showcase'), function()
    {
        Route::get('/', array('uses' => 'AdminShowcaseController@showShowcase', 'as' => 'admin.showcase'));
        Route::group(array('prefix' => 'edit'), function()
        {
            Route::get('/{id?}/', array('uses' => 'AdminShowcaseController@showEdit', 'as' => 'admin.showcase.edit'));
            Route::post('/{id?}/submit/', array('uses' => 'AdminShowcaseController@submitEdit'));
        });
        Route::group(array('prefix' => 'ajax'), function()
        {
            Route::get('/delete/{id?}', array('uses' => 'AdminShowcaseController@ajaxDeleteShowcase', 'as' => 'admin.showcase.ajax.delete'));
        });
    });
});