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
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

	public function showHome()
	{
        $count = array(
            'vc' => Vc::count(),
            'vc_comment' => VcComment::count(),
            'user' => User::count(),
        );

        $data = array(
            'count' => $count,
            'vc_recommend' => Vc::getRecommendWithRating(),
            'vc_list' => Vc::getListOrderByRatingWithRating(),
            'rating_category' => VcRatingCategory::all(),
        );

		return View::make('front.home', $data);
	}

}
