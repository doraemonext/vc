<?php

class AdminHomeController extends BaseController {

    public function __construct() {
        View::composer(array('admin.home'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showHome()
    {
        $data = array(
            'vcs' => Vc::orderBy('datetime', 'DESC')->take(5)->get(),
            'showcases' => Showcase::orderBy('datetime', 'DESC')->take(5)->get(),
            'news' => News::orderBy('datetime', 'DESC')->take(5)->get(),
            'discusses' => Discuss::orderBy('datetime', 'DESC')->take(5)->get(),
        );

        return View::make('admin.home', $data);
    }

}
