<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewsController extends BaseController {

    public function __construct()
    {
        View::composer(array(
            'front.news_item',
        ), function($view)
        {
            if (Sentry::check()) {
                $view->with('user', Sentry::getUser());
            }
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showItem($id)
    {
        $paginateNumber = 10;
        $id = intval($id);

        // 获取新闻信息
        try {
            $news = News::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要展示的新闻信息');
            return Redirect::route('home');
        }

        // 获取评论信息
        $comment = NewsComment::where('news_id', '=', $news->id)->orderBy('datetime');
        $comment_count = $comment->count();
        $comment_paginate = $comment->paginate($paginateNumber);

        $data = array(
            'news' => $news,
            'comment_count' => $comment_count,
            'comment_paginate' => $comment_paginate,
            'news_hot' => News::orderBy('comment_count', 'DESC')->take(7)->get(),
        );

        return View::make('front.news_item', $data);
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
            $news = News::findOrFail($id);
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
        $comment = new NewsComment;
        $comment->news_id = $id;
        $comment->user_id = Sentry::getUser()->id;
        $comment->author_ip = Request::getClientIp();
        $comment->datetime = date("Y-m-d H:i:s");
        $comment->content = $input['content'];
        $comment->agree = 0;
        $comment->disagree = 0;
        $comment->parent = 0;
        $comment->save();
        $news->comment_count = $news->comment_count + 1;
        $news->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加评论');
        return Response::json(array(
            'code' => 0,
        ));
    }

}
