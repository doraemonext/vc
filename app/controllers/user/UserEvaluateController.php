<?php

class UserEvaluateController extends BaseController {

    public function __construct() {
        View::composer(array('user.evaluate_rating', 'user.evaluate_comment'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showRating()
    {
        $paginateNumber = 10;

        $data = array();

        $rating = VcRating::where('user_id', '=', Sentry::getUser()->getId())->orderBy('datetime', 'DESC')->get();
        if ($rating->count() === 0) {
            $data['rating'] = array();
        } else {
            foreach ($rating as $r) {
                $data['rating'][$r->vc_id][$r->vc_rating_category_id]['score'] = $r->score;
                $data['rating'][$r->vc_id]['datetime'] = $r->datetime;
                $data['rating'][$r->vc_id]['vc'] = $r->vc->toArray();
            }
        }

        $data['category'] = VcRatingCategory::all()->toArray();

        return View::make('user.evaluate_rating', $data);
    }

    public function showComment()
    {
        return View::make('user.evaluate_comment');
    }

}
