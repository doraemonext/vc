<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserDiscussController extends BaseController {

    public function __construct() {
        View::composer(array(
            'user.discuss_topic',
            'user.discuss_topic_edit',
            'user.discuss_comment',
            'user.discuss_comment_edit',
        ), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showTopic()
    {
        $paginateNumber = 10;

        // 在数据库中进行查询
        $discusses = Discuss::where('user_id', '=', Sentry::getUser()->getId())->orderBy('datetime', 'DESC')->paginate($paginateNumber);

        return View::make('user.discuss_topic')->with('discusses', $discusses);
    }

    public function showTopicEdit($id)
    {
        $id = intval($id);

        try {
            $discuss = Discuss::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的话题信息');
            return Redirect::route('user.discuss.topic');
        }

        if ($discuss->user_id !== Sentry::getUser()->getId()) {
            Session::flash('status', 'danger');
            Session::flash('message', '您没有修改该话题的权限');
            return Redirect::route('user.discuss.topic');
        }

        $data = array(
            'discuss' => $discuss,
        );

        return View::make('user.discuss_topic_edit', $data);
    }

    public function showComment()
    {
        $paginateNumber = 10;

        // 在数据库中进行查询
        $comments = DiscussComment::where('user_id', '=', Sentry::getUser()->getId())->orderBy('datetime', 'DESC')->paginate($paginateNumber);

        return View::make('user.discuss_comment')->with('comments', $comments);
    }


    public function showCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = DiscussComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的回复信息');
            return Redirect::route('user.discuss.comment');
        }

        if ($comment->user_id !== Sentry::getUser()->getId()) {
            Session::flash('status', 'danger');
            Session::flash('message', '您没有修改该回复的权限');
            return Redirect::route('user.discuss.comment');
        }

        $data = array(
            'comment' => $comment,
        );

        return View::make('user.discuss_comment_edit', $data);
    }

    public function submitTopicEdit($id)
    {
        $id = intval($id);
        try {
            $discuss = Discuss::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的话题信息');
            return Redirect::route('user.discuss.topic');
        }

        if ($discuss->user_id !== Sentry::getUser()->getId()) {
            Session::flash('status', 'danger');
            Session::flash('message', '您没有修改该项目的权限');
            return Redirect::route('user.discuss.topic');
        }

        $input = Input::only('title', 'ckeditor');
        $input['title'] = addslashes(strip_tags($input['title']));

        // 对提交信息进行验证
        $rules = array(
            'title' => 'required|max:255',
            'ckeditor' => 'required|max:10000',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('user.discuss.topic.edit', $discuss->id)->withErrors($validator)->withInput($input);
        }

        $discuss->title = $input['title'];
        $discuss->content = $input['ckeditor'];
        $discuss->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑 '.$input['title']);
        return Redirect::route('user.discuss.topic');
    }

    public function submitCommentEdit($id)
    {
        $id = intval($id);
        try {
            $comment = DiscussComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的回复信息');
            return Redirect::route('user.discuss.comment');
        }

        if ($comment->user_id !== Sentry::getUser()->getId()) {
            Session::flash('status', 'danger');
            Session::flash('message', '您没有修改该回复的权限');
            return Redirect::route('user.discuss.comment');
        }

        $input = Input::only('content');
        $input['content'] = strip_tags($input['content'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'content' => 'required|max:1000',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('user.discuss.comment.edit', $comment->id)->withErrors($validator)->withInput($input);
        }

        $comment->content = $input['content'];
        $comment->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑您的评论');
        return Redirect::route('user.discuss.comment');
    }

    public function ajaxTopicDelete($id = null)
    {
        $id = intval($id);

        try {
            $topic = Discuss::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        if ($topic->user_id !== Sentry::getUser()->getId()) {
            return Response::json(array(
                'code' => 1001,
                'message' => '您没有删除该话题的权限',
            ));
        }

        $topic->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该话题');

        return Response::json(array(
            'code' => 0,
        ));
    }

    public function ajaxCommentDelete($id = null)
    {
        $id = intval($id);

        try {
            $comment = DiscussComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        if ($comment->user_id !== Sentry::getUser()->getId()) {
            return Response::json(array(
                'code' => 1001,
                'message' => '您没有删除该回复的权限',
            ));
        }

        $comment->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该回复');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
