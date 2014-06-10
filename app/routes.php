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
Route::get('/vc/list/', array('uses' => 'VcController@showList', 'as' => 'vc.list'));
Route::get('/vc/item/{id?}/', array('uses' => 'VcController@showItem', 'as' => 'vc.item'));
Route::post('/vc/item/ajax/comment_submit/{id?}/', array('uses' => 'VcController@ajaxCommentSubmit', 'as' => 'vc.item.ajax.comment.submit'));
Route::post('/vc/item/ajax/rating/{id?}/', array('uses' => 'VcController@ajaxRating', 'as' => 'vc.item.ajax.rating'));
Route::post('/vc/item/ajax/vote/{id?}/', array('uses' => 'VcController@ajaxVote', 'as' => 'vc.item.ajax.vote'));

Route::group(array('prefix' => 'news'), function()
{
    Route::get('/item/{id?}/', array('uses' => 'NewsController@showItem', 'as' => 'news.item'));
    Route::post('/item/ajax/comment_submit/{id?}/', array('uses' => 'NewsController@ajaxCommentSubmit', 'as' => 'news.item.ajax.comment.submit'));
});

Route::group(array('prefix' => 'showcase'), function()
{
    Route::get('/list/', array('uses' => 'ShowcaseController@showList', 'as' => 'showcase.list'));
    Route::get('/item/{id?}/', array('uses' => 'ShowcaseController@showItem', 'as' => 'showcase.item'));
    Route::post('/item/ajax/comment_submit/{id?}/', array('uses' => 'ShowcaseController@ajaxCommentSubmit', 'as' => 'showcase.item.ajax.comment.submit'));
    Route::post('/item/ajax/vote/{id?}/', array('uses' => 'ShowcaseController@ajaxVote', 'as' => 'showcase.item.ajax.vote'));
});

Route::group(array('prefix' => 'discuss'), function()
{
    Route::get('/list/', array('uses' => 'DiscussController@showList', 'as' => 'discuss.list'));
    Route::get('/item/{id?}/', array('uses' => 'DiscussController@showItem', 'as' => 'discuss.item'));
    Route::post('/item/ajax/comment_submit/{id?}/', array('uses' => 'DiscussController@ajaxCommentSubmit', 'as' => 'discuss.item.ajax.comment.submit'));
    Route::post('/item/ajax/vote/{id?}/', array('uses' => 'DiscussController@ajaxVote', 'as' => 'discuss.item.ajax.vote'));
});

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

Route::group(array('prefix' => 'user', 'before' => 'Sentry'), function()
{
    Route::get('/', array('uses' => 'UserHomeController@showHome', 'as' => 'user.home'));
    Route::group(array('prefix' => 'showcase'), function()
    {
        Route::get('/', array('uses' => 'UserShowcaseController@showShowcase', 'as' => 'user.showcase'));
        Route::group(array('prefix' => 'new'), function()
        {
            Route::get('/', array('uses' => 'UserShowcaseController@showNew', 'as' => 'user.showcase.new'));
            Route::post('/submit/', array('uses' => 'UserShowcaseController@submitNew'));
        });
        Route::group(array('prefix' => 'edit'), function()
        {
            Route::get('/{id?}/', array('uses' => 'UserShowcaseController@showEdit', 'as' => 'user.showcase.edit'));
            Route::post('/{id?}/submit/', array('uses' => 'UserShowcaseController@submitEdit'));
        });
        Route::group(array('prefix' => 'ajax'), function()
        {
            Route::get('/delete/{id?}', array('uses' => 'UserShowcaseController@ajaxDeleteShowcase', 'as' => 'user.showcase.ajax.delete'));
        });
    });
    Route::group(array('prefix' => 'evaluate'), function()
    {
        Route::get('/rating/', array('uses' => 'UserEvaluateController@showRating', 'as' => 'user.evaluate.rating'));
        Route::group(array('prefix' => 'comment'), function()
        {
            Route::get('/vc/', array('uses' => 'UserEvaluateController@showCommentVc', 'as' => 'user.evaluate.comment.vc'));
            Route::get('/vc/edit/{id?}/', array('uses' => 'UserEvaluateController@showCommentVcEdit', 'as' => 'user.evaluate.comment.vc.edit'));
            Route::post('/vc/edit/{id?}/submit/', array('before' => 'csrf', 'uses' => 'UserEvaluateController@submitCommentVc'));
            Route::get('/vc/ajax/delete/{id?}', array('uses' => 'UserEvaluateController@ajaxCommentVcDelete', 'as' => 'user.evaluate.comment.vc.ajax.delete'));

            Route::get('/showcase/', array('uses' => 'UserEvaluateController@showCommentShowcase', 'as' => 'user.evaluate.comment.showcase'));
            Route::get('/showcase/edit/{id?}/', array('uses' => 'UserEvaluateController@showCommentShowcaseEdit', 'as' => 'user.evaluate.comment.showcase.edit'));
            Route::post('/showcase/edit/{id?}/submit/', array('before' => 'csrf', 'uses' => 'UserEvaluateController@submitCommentShowcase'));
            Route::get('/showcase/ajax/delete/{id?}', array('uses' => 'UserEvaluateController@ajaxCommentShowcaseDelete', 'as' => 'user.evaluate.comment.showcase.ajax.delete'));

            Route::get('/news/', array('uses' => 'UserEvaluateController@showCommentNews', 'as' => 'user.evaluate.comment.news'));
            Route::get('/news/edit/{id?}/', array('uses' => 'UserEvaluateController@showCommentNewsEdit', 'as' => 'user.evaluate.comment.news.edit'));
            Route::post('/news/edit/{id?}/submit/', array('before' => 'csrf', 'uses' => 'UserEvaluateController@submitCommentNews'));
            Route::get('/news/ajax/delete/{id?}', array('uses' => 'UserEvaluateController@ajaxCommentNewsDelete', 'as' => 'user.evaluate.comment.news.ajax.delete'));
        });
    });
    Route::group(array('prefix' => 'discuss'), function()
    {
        Route::get('/topic/', array('uses' => 'UserDiscussController@showTopic', 'as' => 'user.discuss.topic'));
        Route::get('/topic/edit/{id?}/', array('uses' => 'UserDiscussController@showTopicEdit', 'as' => 'user.discuss.topic.edit'));
        Route::post('/topic/edit/{id?}/submit/', array('uses' => 'UserDiscussController@submitTopicEdit'));
        Route::get('/topic/ajax/delete/{id?}', array('uses' => 'UserDiscussController@ajaxTopicDelete', 'as' => 'user.discuss.topic.ajax.delete'));

        Route::get('/comment/', array('uses' => 'UserDiscussController@showComment', 'as' => 'user.discuss.comment'));
        Route::get('/comment/edit/{id?}/', array('uses' => 'UserDiscussController@showCommentEdit', 'as' => 'user.discuss.comment.edit'));
        Route::post('/comment/edit/{id?}/submit/', array('uses' => 'UserDiscussController@submitCommentEdit'));
        Route::get('/comment/ajax/delete/{id?}', array('uses' => 'UserDiscussController@ajaxCommentDelete', 'as' => 'user.discuss.comment.ajax.delete'));
    });
    Route::group(array('prefix' => 'setting'), function()
    {
        Route::get('/', array('uses' => 'UserSettingController@showSetting', 'as' => 'user.setting'));
        Route::post('/submit/', array('before' => 'csrf', 'uses' => 'UserSettingController@submitSetting'));
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

        Route::group(array('prefix' => 'comment'), function()
        {
            Route::get('/', array('uses' => 'AdminVcController@showComment', 'as' => 'admin.vc.comment'));
            Route::get('/edit/{id?}/', array('uses' => 'AdminVcController@showCommentEdit', 'as' => 'admin.vc.comment.edit'));
            Route::post('/edit/{id?}/submit/', array('before' => 'csrf', 'uses' => 'AdminVcController@submitCommentEdit'));
            Route::get('/ajax/delete/{id?}', array('uses' => 'AdminVcController@ajaxCommentDelete', 'as' => 'admin.vc.comment.ajax.delete'));
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

        Route::group(array('prefix' => 'comment'), function()
        {
            Route::get('/', array('uses' => 'AdminShowcaseController@showComment', 'as' => 'admin.showcase.comment'));
            Route::get('/edit/{id?}/', array('uses' => 'AdminShowcaseController@showCommentEdit', 'as' => 'admin.showcase.comment.edit'));
            Route::post('/edit/{id?}/submit/', array('before' => 'csrf', 'uses' => 'AdminShowcaseController@submitCommentEdit'));
            Route::get('/ajax/delete/{id?}', array('uses' => 'AdminShowcaseController@ajaxCommentDelete', 'as' => 'admin.showcase.comment.ajax.delete'));
        });
    });

    // 新闻管理
    Route::group(array('prefix' => 'news'), function()
    {
        Route::get('/', array('uses' => 'AdminNewsController@showNews', 'as' => 'admin.news'));
        Route::group(array('prefix' => 'new'), function()
        {
            Route::get('/', array('uses' => 'AdminNewsController@showNew', 'as' => 'admin.news.new'));
            Route::post('/submit/', array('before' => 'csrf', 'uses' => 'AdminNewsController@submitNew'));
        });
        Route::group(array('prefix' => 'edit'), function()
        {
            Route::get('/{id?}/', array('uses' => 'AdminNewsController@showEdit', 'as' => 'admin.news.edit'));
            Route::post('/{id?}/submit/', array('uses' => 'AdminNewsController@submitEdit'));
        });
        Route::group(array('prefix' => 'ajax'), function()
        {
            Route::get('/delete/{id?}', array('uses' => 'AdminNewsController@ajaxDeleteNews', 'as' => 'admin.news.ajax.delete'));
        });

        Route::group(array('prefix' => 'comment'), function()
        {
            Route::get('/', array('uses' => 'AdminNewsController@showComment', 'as' => 'admin.news.comment'));
            Route::get('/edit/{id?}/', array('uses' => 'AdminNewsController@showCommentEdit', 'as' => 'admin.news.comment.edit'));
            Route::post('/edit/{id?}/submit/', array('before' => 'csrf', 'uses' => 'AdminNewsController@submitCommentEdit'));
            Route::get('/ajax/delete/{id?}', array('uses' => 'AdminNewsController@ajaxCommentDelete', 'as' => 'admin.news.comment.ajax.delete'));
        });
    });

    // 会员管理
    Route::group(array('prefix' => 'user'), function()
    {
        Route::get('/', array('uses' => 'AdminUserController@showUser', 'as' => 'admin.user'));
        Route::group(array('prefix' => 'new'), function()
        {
            Route::get('/', array('uses' => 'AdminUserController@showNew', 'as' => 'admin.user.new'));
            Route::post('/submit/', array('before' => 'csrf', 'uses' => 'AdminUserController@submitNew'));
        });
        Route::group(array('prefix' => 'edit'), function()
        {
            Route::get('/{id?}/', array('uses' => 'AdminUserController@showEdit', 'as' => 'admin.user.edit'));
            Route::post('/{id?}/submit/', array('uses' => 'AdminUserController@submitEdit'));
        });
        Route::group(array('prefix' => 'ajax'), function()
        {
            Route::get('/delete/{id?}', array('uses' => 'AdminUserController@ajaxDeleteUser', 'as' => 'admin.user.ajax.delete'));
        });
    });

    // 广告管理
    Route::group(array('prefix' => 'ad'), function()
    {
        Route::get('/', array('uses' => 'AdminAdController@showAd', 'as' => 'admin.ad'));
        Route::group(array('prefix' => 'new'), function()
        {
            Route::get('/', array('uses' => 'AdminAdController@showNew', 'as' => 'admin.ad.new'));
            Route::post('/submit/', array('before' => 'csrf', 'uses' => 'AdminAdController@submitNew'));
        });
        Route::group(array('prefix' => 'edit'), function()
        {
            Route::get('/{id?}/', array('uses' => 'AdminAdController@showEdit', 'as' => 'admin.ad.edit'));
            Route::post('/{id?}/submit/', array('uses' => 'AdminAdController@submitEdit'));
        });
        Route::group(array('prefix' => 'ajax'), function()
        {
            Route::get('/delete/{id?}', array('uses' => 'AdminAdController@ajaxAdDelete', 'as' => 'admin.ad.ajax.delete'));
        });
    });
});