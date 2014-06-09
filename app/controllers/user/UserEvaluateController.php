<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserEvaluateController extends BaseController {

    public function __construct() {
        View::composer(array(
            'user.evaluate_rating',
            'user.evaluate_comment',
            'user.evaluate_comment_edit',
        ), function($view)
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

        $data['category'] = VcRatingCategory::all()->toArray();

        $rating = VcRating::where('user_id', '=', Sentry::getUser()->getId())->orderBy('datetime', 'DESC')->get();
        if ($rating->count() === 0) {
            $data['rating'] = array();
        } else {
            $vc_id_array = array();
            foreach ($rating as $r) {
                // 存储当前用户评价的所有VC ID
                $vc_id_array[$r->vc_id] = 1;
            }

            // 为每个分类的评分都赋初值，防止无效访问
            foreach ($vc_id_array as $vc_id => $value) {
                foreach ($data['category'] as $category) {
                    $data['rating'][$vc_id][$category['id']]['score'] = 0.0;
                }
            }

            foreach ($rating as $r) {
                $data['rating'][$r->vc_id][$r->vc_rating_category_id]['score'] = $r->score;
                $data['rating'][$r->vc_id]['datetime'] = $r->datetime;
                $data['rating'][$r->vc_id]['vc'] = $r->vc->toArray();
            }
        }

        return View::make('user.evaluate_rating', $data);
    }

    public function showComment()
    {
        $paginateNumber = 10;

        $comments = VcComment::where('user_id', '=', Sentry::getUser()->getId())->orderBy('datetime', 'DESC')->paginate($paginateNumber);

        $data = array(
            'comments' => $comments,
        );

        return View::make('user.evaluate_comment', $data);
    }

    public function showCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = VcComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('user.evaluate.comment');
        }

        if ($comment->user_id !== Sentry::getUser()->getId()) {
            Session::flash('status', 'danger');
            Session::flash('message', '您没有权限编辑该条评论');
            return Redirect::route('user.evaluate.comment');
        }

        $data = array(
            'comment' => $comment,
        );

        return View::make('user.evaluate_comment_edit', $data);
    }

    public function submitEditComment($id)
    {
        $id = intval($id);

        try {
            $comment = VcComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('user.evaluate.comment');
        }

        $input = Input::only('content');
        $input['content'] = addslashes(strip_tags($input['content']));

        // 对提交信息进行验证
        $rules = array(
            'content' => 'required|max:2000',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('user.evaluate.comment.edit', $comment->id)->withErrors($validator)->withInput($input);
        }

        $comment->content = $input['content'];
        $comment->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑该条评论');
        return Redirect::route('user.evaluate.comment');
    }

    public function ajaxDeleteComment($id = null)
    {
        $id = intval($id);

        try {
            $comment = VcComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        if ($comment->user_id !== Sentry::getUser()->getId()) {
            return Response::json(array(
                'code' => 1001,
                'message' => '您没有删除该条评论的权限',
            ));
        }

        $comment->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条评论');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
