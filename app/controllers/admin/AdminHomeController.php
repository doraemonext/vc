<?php

class AdminHomeController extends BaseController {

    public function __construct() {
        View::composer(array('admin.home'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showHome()
    {
        return View::make('admin.home');
    }

}
