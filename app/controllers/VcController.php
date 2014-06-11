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
        $paginateNumber = 10;

        // 获取VC信息
        $vc_recommend = Vc::where('recommended', '=', '1')->get();
        $vc_list = Vc::orderBy('rating', 'DESC')->paginate($paginateNumber);
        foreach ($vc_recommend as $vc) {
            $vc->score = $this->getRatingByVC($vc->id);
        }
        foreach ($vc_list as $vc) {
            $vc->score = $this->getRatingByVC($vc->id);
        }

        // 获取VC动态
        $news_category = NewsCategory::where('title', '=', 'VC动态')->get()->first()->id;
        $news_list = News::where('category_id', '=', $news_category)->orderBy('datetime', 'DESC')->take(8)->get();

        $data = array(
            'vc_recommend' => $vc_recommend,
            'vc_list' => $vc_list,
            'rating_category' => VcRatingCategory::all(),
            'news_list' => $news_list,
        );

        return View::make('front.vc_list', $data);
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
            Session::flash('message', '找不到您要查看的投资方信息');
            return Redirect::route('vc.list');
        }

        // 获取VC动态
        $news_category = NewsCategory::where('title', '=', 'VC动态')->get()->first()->id;
        $news_list = News::where('category_id', '=', $news_category)->orderBy('datetime', 'DESC')->take(8)->get();

        // 获取评论信息
        $comment = VcComment::where('vc_id', '=', $vc->id)->orderBy('datetime');
        $comment_count = $comment->count();
        $comment_paginate = $comment->paginate($paginateNumber);

        $data = array(
            'vc' => $vc,
            'comment_count' => $comment_count,
            'comment_paginate' => $comment_paginate,
            'rating_category' => VcRatingCategory::all(),
            'rating' => $this->getRatingByVC($vc->id),
            'news_list' => $news_list,
        );

        return View::make('front.vc_item', $data);
    }

    public function ajaxCommentSubmit($id)
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
        $vc->comment_count = $vc->comment_count + 1;
        $vc->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加评论');
        return Response::json(array(
            'code' => 0,
        ));
    }

    public function ajaxRating($id)
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

        if (VcRating::where('user_id', '=', Sentry::getUser()->getId())->where('vc_id', '=', $id)->count() > 0) {
            return Response::json(array(
                'code' => 1004,
                'message' => '您已经评分过，不能重复评分',
            ));
        }

        $rating_category = VcRatingCategory::all();
        foreach ($rating_category as $category) {
            $score = floatval(Input::get('rating_'.$category->id));
            if ($score < 0.0 || $score > 5.0) {
                return Response::json(array(
                    'code' => 1003,
                    'message' => '您的评分有误，范围为０~5',
                ));
            }

            $rating = new VcRating;
            $rating->vc_id = $id;
            $rating->user_id = Sentry::getUser()->getId();
            $rating->vc_rating_category_id = $category->id;
            $rating->score = $score;
            $rating->datetime = date("Y-m-d H:i:s");
            $rating->save();
        }

        $vc->rating = $this->getRatingByVC($vc->id)[0];
        $vc->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功评分');
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

    public function ajaxVcList($page)
    {
        $paginateNumber = intval(Setting::where('title', '=', 'paginate_home_sidebar_vc_list')->first()->value);

        $vc_list = Vc::getListOrderByRatingWithRating($paginateNumber, ($page - 1) * $paginateNumber);
        $vc_list_view = View::make('front.ajax.sidebar_vc_list', array(
            'vc_list' => $vc_list,
            'rating_category' => VcRatingCategory::all(),
        ))->render();

        if ($page * $paginateNumber < Vc::count()) {
            $has_next = true;
        } else {
            $has_next = false;
        }

        return Response::json(array(
            'code' => 0,
            'vc_list' => $vc_list_view,
            'has_prev' => $page == 1 ? false : true,
            'has_next' => $has_next,
        ));
    }

}
