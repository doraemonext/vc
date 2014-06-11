<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowcaseController extends BaseController {

    public function __construct()
    {
        View::composer(array(
            'front.showcase_list',
            'front.showcase_item',
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

        // 获取项目信息
        $showcase_list = Showcase::orderBy('datetime', 'DESC')->paginate($paginateNumber);

        // 获取热门新闻
        $news_hot = News::orderBy('comment_count', 'DESC')->take(6)->get();

        $data = array(
            'showcase_list' => $showcase_list,
            'news_hot' => $news_hot,
            'discuss_latest' => Discuss::orderBy('datetime', 'DESC')->take(3)->get(),
        );

        return View::make('front.showcase_list', $data);
    }

    public function showItem($id)
    {
        $paginateNumber = 10;
        $id = intval($id);

        // 获取项目信息
        try {
            $showcase = Showcase::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要查看的项目信息');
            return Redirect::route('showcase.list');
        }

        // 获取评论信息
        $comment = ShowcaseComment::where('showcase_id', '=', $showcase->id)->orderBy('datetime');
        $comment_count = $comment->count();
        $comment_paginate = $comment->paginate($paginateNumber);

        // 获取热门新闻
        $news_hot = News::orderBy('comment_count', 'DESC')->take(6)->get();

        // 获取最新项目
        $showcase_latest = Showcase::orderBy('datetime', 'DESC')->take(8)->get();

        $data = array(
            'showcase' => $showcase,
            'comment_count' => $comment_count,
            'comment_paginate' => $comment_paginate,
            'news_hot' => $news_hot,
            'showcase_latest' => $showcase_latest,
            'discuss_latest' => Discuss::orderBy('datetime', 'DESC')->take(3)->get(),
        );

        return View::make('front.showcase_item', $data);
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
            $showcase = Showcase::findOrFail($id);
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
        $comment = new ShowcaseComment;
        $comment->showcase_id = $id;
        $comment->user_id = Sentry::getUser()->id;
        $comment->author_ip = Request::getClientIp();
        $comment->datetime = date("Y-m-d H:i:s");
        $comment->content = $input['content'];
        $comment->agree = 0;
        $comment->disagree = 0;
        $comment->parent = 0;
        $comment->save();
        $showcase->comment_count = $showcase->comment_count + 1;
        $showcase->save();

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
            $showcase = Showcase::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $showcase->vote = $showcase->vote + 1;
        $showcase->save();

        return Response::json(array(
            'code' => 0,
            'vote_count' => $showcase->vote,
        ));
    }

}
