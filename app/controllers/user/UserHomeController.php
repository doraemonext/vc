<?php

class UserHomeController extends BaseController {

    public function __construct() {
        View::composer(array('user.home'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showHome()
    {
        $user_id = Sentry::getUser()->getId();
        $data = array(
            'showcases' => Showcase::where('user_id', '=', $user_id)->orderBy('datetime', 'DESC')->take(5)->get(),
            'comments_vc' => VcComment::where('user_id', '=', $user_id)->orderBy('datetime', 'DESC')->take(5)->get(),
            'comments_showcase' => ShowcaseComment::where('user_id', '=', $user_id)->orderBy('datetime', 'DESC')->take(5)->get(),
            'comments_news' => NewsComment::where('user_id', '=', $user_id)->orderBy('datetime', 'DESC')->take(5)->get(),
            'discusses' => Discuss::where('user_id', '=', $user_id)->orderBy('datetime', 'DESC')->take(5)->get(),
            'discuss_comments' => DiscussComment::where('user_id', '=', $user_id)->orderBy('datetime', 'DESC')->take(5)->get(),
        );

        return View::make('user.home', $data);
    }

}
