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

    public function ajaxCommentSubmit($id)
    {
        $id = intval($id);

        try {
            Vc::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $input = Input::only('content');
        $input['content'] = strip_tags($input['content'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'content' => 'required|max:1024',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Response::json(array(
                'code' => 1001,
                'message' => $validator->messages()->all('<li>:message</li>'),
            ));
        }

        // 在数据库中插入新评论
        $comment = new VcComment;
        $comment->vc_id = $id;
        $comment->user_id = Sentry::getUser()->id;
        $comment->author_ip = Request::getClientIp();
        $comment->datetime = date("Y-m-d H:i:s");
        $comment->content = $input['content'];
        $comment->agree = 0;
        $comment->disagree = 0;
        $comment->parent = 0;
        $comment->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加评论');
        return Response::json(array(
            'code' => 0,
        ));
    }

    public function ajaxVote($id)
    {
        if (!Sentry::check()) {
            return Response::json(array(
                'code' => 1002,
                'message' => '您尚未登陆，请登陆后重试',
            ));
        }

        $id = intval($id);

        try {
            $vc = Vc::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $vc->vote = $vc->vote + 1;
        $vc->save();

        return Response::json(array(
            'code' => 0,
            'vote_count' => $vc->vote,
        ));
    }

}
