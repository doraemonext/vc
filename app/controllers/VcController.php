<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class VcController extends BaseController {

    public function __construct()
    {
        View::composer(array(
            'front.vc_list',
            'front.vc_item',
        ), function($view)
        {
            if (Sentry::check()) {
                $view->with('user', Sentry::getUser());
            }
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showList()
    {
        return View::make('front.vc_list');
    }

    public function showItem($id)
    {
        $paginateNumber = 10;
        $id = intval($id);

        // 获取VC信息
        try {
            $vc = Vc::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的投资方信息');
            return Redirect::route('vc.list');
        }

        // 获取评论信息
        $comment = VcComment::where('vc_id', '=', $vc->id)->orderBy('datetime');
        $comment_count = $comment->count();
        $comment_paginate = $comment->paginate($paginateNumber);

        // 获取评分信息
        $rating = VcRating::where('vc_id', '=', $vc->id);
        $rating_category = VcRatingCategory::all();
        $score_result = array();
        foreach ($rating_category as $category) {
            $total = DB::table($rating->getModel()->getTable())->where('vc_rating_category_id', '=', $category->id)->sum('score');
            $count = DB::table($rating->getModel()->getTable())->where('vc_rating_category_id', '=', $category->id)->count();
            if ($count > 0) {
                $score = $total / $count;
            } else {
                $score = 0.0;
            }
            $score_result[$category->id] = $score;
        }

        $data = array(
            'vc' => $vc,
            'comment_count' => $comment_count,
            'comment_paginate' => $comment_paginate,
            'rating_category' => $rating_category,
            'rating' => $score_result,
        );

        return View::make('front.vc_item', $data);
    }

}
