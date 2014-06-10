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
            'showcase_recommend' => Showcase::getRecommend(),
            'news_hot' => News::orderBy('comment_count', 'DESC')->take(6)->get(),
            'news_latest' => News::orderBy('datetime', 'DESC')->take(8)->get(),
            'ad_top' => Ad::where('position_id', '=', 1)->get(),
        );

		return View::make('front.home', $data);
	}

}
