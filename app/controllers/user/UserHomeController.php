<?php

class UserHomeController extends BaseController {

    public function __construct() {
        View::composer(array('user.home'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showHome()
    {
        return View::make('user.home');
    }

}
