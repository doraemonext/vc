<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AdminShowcaseController extends BaseController {

    public function __construct() {
        View::composer(array(
            'admin.showcase',
            'admin.showcase_edit',
            'admin.comment',
            'admin.comment_edit',
        ), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showShowcase()
    {
        $paginateNumber = 10;

        // 在数据库中进行查询
        $showcases = Showcase::orderBy('datetime', 'DESC')->paginate($paginateNumber);

        return View::make('admin.showcase')->with('showcases', $showcases);
    }

    public function showEdit($id)
    {
        $id = intval($id);

        try {
            $showcase = Showcase::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的项目信息');
            return Redirect::route('admin.showcase');
        }

        // 生成分类列表，供view使用
        $category = $showcase->category->all();
        $category_select = array();
        foreach ($category as $k) {
            $category_select[$k->id] = $k->title;
        }

        return View::make('admin.showcase_edit')->with('showcase', $showcase)->with('category_select', $category_select);
    }

    public function showComment()
    {
        $paginateNumber = 10;

        $comments = ShowcaseComment::orderBy('datetime', 'DESC')->paginate($paginateNumber);

        $data = array(
            'type' => 'showcase',
            'comments' => $comments,
        );

        return View::make('admin.comment', $data);
    }

    public function showCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = ShowcaseComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('admin.showcase.comment');
        }

        $data = array(
            'type' => 'showcase',
            'comment' => $comment,
        );

        return View::make('admin.comment_edit', $data);
    }

    public function submitEdit($id)
    {
        $id = intval($id);
        try {
            $showcase = Showcase::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的项目信息');
            return Redirect::route('admin.showcase');
        }

        $input = Input::only('name', 'recommended', 'company', 'contact_person', 'contact_email', 'contact_phone', 'category_id', 'operation_time', 'summary', 'ckeditor');
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['recommended'] = addslashes(strip_tags($input['recommended']));
        $input['company'] = addslashes(strip_tags($input['company']));
        $input['contact_person'] = addslashes(strip_tags($input['contact_person']));
        $input['contact_email'] = addslashes(strip_tags($input['contact_email']));
        $input['contact_phone'] = addslashes(strip_tags($input['contact_phone']));
        $input['category_id'] = addslashes(strip_tags($input['category_id']));
        $input['operation_time'] = addslashes(strip_tags($input['operation_time']));
        $input['summary'] = strip_tags($input['summary'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'name' => 'required|max:255',
            'recommended' => 'required',
            'company' => 'max:255',
            'contact_person' => 'max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'max:255',
            'category_id' => 'max:255',
            'operation_time' => 'max:255',
            'summary' => 'max:120',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.showcase.edit', $showcase->id)->withErrors($validator)->withInput($input);
        }

        // 对Logo图片进行处理
        $input['logo'] = Input::file('logo');
        $filename = '';
        $config = Config::get('upload', array('showcase.logo', 'showcase.logo.default'));
        if (!is_null($input['logo'])) {
            if ($input['logo']->getError()) {
                Session::flash('error', $input['logo']->getErrorMessage());
                return Redirect::route('admin.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }

            $destination = $config['showcase.logo'];
            do {
                $filename = str_random(64);
            } while (file_exists($destination.$filename));

            $mime = $input['logo']->getMimeType();
            if ($mime === 'image/gif') {
                $filename .= '.gif';
            } elseif ($mime === 'image/jpeg') {
                $filename .= '.jpg';
            } elseif ($mime === 'image/png') {
                $filename .= '.png';
            } else {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('admin.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }

            try {
                $input['logo']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('admin.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }
        }

        $showcase->name = $input['name'];
        $showcase->recommended = ($input['recommended'] == '1') ? 1 : 0;
        if (!is_null($input['logo'])) {
            if ($showcase->logo != 'default.jpg') {
                Croppa::delete($destination.$showcase->logo);
            }
            $showcase->logo = $filename;
        }
        $showcase->company = $input['company'];
        $showcase->contact_person = $input['contact_person'];
        $showcase->contact_email = $input['contact_email'];
        $showcase->contact_phone = $input['contact_phone'];
        $showcase->category_id = $input['category_id'];
        $showcase->operation_time = $input['operation_time'];
        $showcase->summary = $input['summary'];
        $showcase->content = $input['ckeditor'];
        $showcase->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑 '.$input['name']);
        return Redirect::route('admin.showcase');
    }

    public function submitCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = ShowcaseComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('admin.showcase.comment');
        }

        $input = Input::only('content');
        $input['content'] = addslashes(strip_tags($input['content']));

        // 对提交信息进行验证
        $rules = array(
            'content' => 'required|max:2000',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.showcase.comment.edit', $comment->id)->withErrors($validator)->withInput($input);
        }

        $comment->content = $input['content'];
        $comment->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑该条评论');
        return Redirect::route('admin.showcase.comment');
    }

    public function ajaxDeleteShowcase($id = null)
    {
        $id = intval($id);

        try {
            $showcase = Showcase::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        ShowcaseComment::where('showcase_id', '=', $showcase->id)->delete();
        Croppa::delete(Config::get('upload')['showcase.logo'].$showcase->logo);
        $showcase->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条项目记录');

        return Response::json(array(
            'code' => 0,
        ));
    }

    public function ajaxCommentDelete($id = null)
    {
        $id = intval($id);

        try {
            $comment = ShowcaseComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $comment->showcase->comment_count = $comment->showcase->comment_count - 1;
        $comment->showcase->save();

        $comment->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条评论');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
