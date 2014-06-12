<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiscussController extends BaseController {

    public function __construct()
    {
        View::composer(array(
            'front.discuss_list',
            'front.discuss_item',
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

    public function showList()
    {
        $paginateNumber = 10;

        // 获取话题信息
        $discuss_list = Discuss::orderBy('datetime', 'DESC')->paginate($paginateNumber);

        // 获取最热话题
        $discuss_hot = Discuss::orderBy('comment_count', 'DESC')->orderBy('vote', 'DESC')->take(3)->get();

        // 获取最新话题
        $discuss_latest = Discuss::orderBy('datetime', 'DESC')->take(8)->get();

        $data = array(
            'discuss_list' => $discuss_list,
            'discuss_hot' => $discuss_hot,
            'discuss_latest' => $discuss_latest,
        );

        return View::make('front.discuss_list', $data);
    }

    public function showItem($id)
    {
        $paginateNumber = 10;
        $id = intval($id);

        // 获取项目信息
        try {
            $discuss = Discuss::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要查看的话题信息');
            return Redirect::route('discuss.list');
        }

        // 获取评论信息
        $comment = DiscussComment::where('discuss_id', '=', $discuss->id)->orderBy('datetime');
        $comment_count = $comment->count();
        $comment_paginate = $comment->paginate($paginateNumber);

        // 获取最热话题
        $discuss_hot = Discuss::orderBy('comment_count', 'DESC')->orderBy('vote', 'DESC')->take(3)->get();

        // 获取最新项目
        $showcase_latest = Showcase::orderBy('datetime', 'DESC')->take(8)->get();

        $data = array(
            'discuss' => $discuss,
            'comment_count' => $comment_count,
            'comment_paginate' => $comment_paginate,
            'discuss_hot' => $discuss_hot,
            'showcase_latest' => $showcase_latest,
        );

        return View::make('front.discuss_item', $data);
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
            $discuss = Discuss::findOrFail($id);
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
        $comment = new DiscussComment;
        $comment->discuss_id = $id;
        $comment->user_id = Sentry::getUser()->id;
        $comment->author_ip = Request::getClientIp();
        $comment->datetime = date("Y-m-d H:i:s");
        $comment->content = $input['content'];
        $comment->agree = 0;
        $comment->disagree = 0;
        $comment->parent = 0;
        $comment->save();
        $discuss->comment_count = $discuss->comment_count + 1;
        $discuss->save();

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
            $discuss = Discuss::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $discuss->vote = $discuss->vote + 1;
        $discuss->save();

        return Response::json(array(
            'code' => 0,
            'vote_count' => $discuss->vote,
        ));
    }

    public function ajaxTopicSubmit()
    {
        if (!Sentry::check()) {
            return Response::json(array(
                'code' => 1002,
                'message' => '您尚未登陆，请登陆后重试',
            ));
        }

        $input = Input::only('title', 'content');
        $input['title'] = strip_tags(addslashes($input['title']));
        $input['content'] = strip_tags($input['content'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'title' => 'required|max:255',
            'content' => 'required|max:10240',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Response::json(array(
                'code' => 1001,
                'message' => $validator->messages()->all('<li>:message</li>'),
            ));
        }

        // 在数据库中插入新话题
        $discuss = new Discuss;
        $discuss->user_id = Sentry::getUser()->id;
        $discuss->title = $input['title'];
        $discuss->content = $input['content'];
        $discuss->vote = 0;
        $discuss->recommended = 0;
        $discuss->comment_count = 0;
        $discuss->datetime = date("Y-m-d H:i:s");
        $discuss->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功发表话题');
        return Response::json(array(
            'code' => 0,
            'url' => route('discuss.item', $discuss->id),
        ));
    }

}
