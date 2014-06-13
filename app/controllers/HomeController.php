<?php

class HomeController extends BaseController {

    public function __construct()
    {
        View::composer(array(
            'front.home',
            'front.business',
        ), function($view)
        {
            if (Sentry::check()) {
                $view->with('user', Sentry::getUser());
            }
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

	public function showHome()
	{
        $paginateNewsNumber = intval(Setting::where('title', '=', 'paginate_home_news_list')->first()->value);
        $setting = Setting::getSetting();

        $count = array(
            'vc' => (empty($setting['count_vc'])) ? Vc::count() : $setting['count_vc'],
            'comment' => (empty($setting['count_comment'])) ? VcComment::count() + ShowcaseComment::count() + NewsComment::count() + Discuss::count() : $setting['count_comment'],
            'user' => (empty($setting['count_user'])) ? User::count() : $setting['count_user']
        );

        $data = array(
            'count' => $count,
            'vc_recommend' => Vc::getRecommendWithRating(intval(Setting::where('title', '=', 'paginate_home_sidebar_vc_recommend')->first()->value)),
            'vc_list' => Vc::getListOrderByRatingWithRating(intval(Setting::where('title', '=', 'paginate_home_sidebar_vc_list')->first()->value)),
            'rating_category' => VcRatingCategory::all(),
            'showcase_recommend' => Showcase::getRecommend(),
            'news_hot' => News::orderBy('comment_count', 'DESC')->take(6)->get(),
            'news_latest' => News::orderBy('datetime', 'DESC')->paginate($paginateNewsNumber),
            'discuss_latest' => Discuss::orderBy('datetime', 'DESC')->take(3)->get(),
            'ad_top' => Ad::where('position_id', '=', 1)->get(),
        );

		return View::make('front.home', $data);
	}

    public function showBusiness()
    {
        return View::make('front.business');
    }

}
