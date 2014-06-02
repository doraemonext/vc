<?php

class AdminHomeController extends BaseController {

    public function __construct() {
        View::composer(array('admin.home'), function($view)
        {
            $view->with('user', Sentry::getUser());
        });
    }

    public function showHome()
    {
        return View::make('admin.home');
    }

}
