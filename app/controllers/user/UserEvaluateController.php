<?php

class UserEvaluateController extends BaseController {

    public function __construct() {
        View::composer(array('user.evaluate_rating', 'user.evaluate_comment'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showRating()
    {
        $paginateNumber = 10;

        return View::make('user.evaluate_rating');
    }

    public function showComment()
    {
        return View::make('user.evaluate_comment');
    }

}
