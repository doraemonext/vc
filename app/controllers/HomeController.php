<?php

class HomeController extends BaseController {

    public function __construct()
    {
        View::composer(array(
            'front.home',
        ), function($view)
        {
            if (Sentry::check()) {
                $view->with('user', Sentry::getUser());
            }
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

	public function showHome()
	{
        $count = array(
            'vc' => Vc::count(),
            'user' => User::count(),
        );

		return View::make('front.home')->with('count', $count);
	}

}
