<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AdminNewsController extends BaseController {

    public function __construct() {
        View::composer(array(
            'admin.news',
            'admin.news_edit',
            'admin.comment',
            'admin.comment_edit',
        ), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showNews()
    {
        $paginateNumber = 10;
        $input = Input::only('search');

        // 对排序关键字及顺序进行错误处理
        if (!is_null($input['search'])) {
            $input['search'] = addslashes($input['search']);
        }

        // 在数据库中进行查询
        if (is_null($input['search'])) {
            $news = News::orderBy('datetime', 'DESC')->paginate($paginateNumber);
        } else {
            $news = News::where('title', 'LIKE', '%'.$input['search'].'%')->orderBy('datetime', 'DESC')->paginate($paginateNumber);
        }

        return View::make('admin.news')->with('input', $input)->with('news', $news);
    }

    public function showNew()
    {
        // 生成分类列表，供view使用
        $category = NewsCategory::all();
        $category_select = array();
        foreach ($category as $k) {
            $category_select[$k->id] = $k->title;
        }

        return View::make('admin.news_edit')->with('category_select', $category_select);
    }

    public function showEdit($id)
    {
        $id = intval($id);

        try {
            $news = News::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的新闻信息');
            return Redirect::route('admin.news');
        }

        // 生成分类列表，供view使用
        $category = $news->category->all();
        $category_select = array();
        foreach ($category as $k) {
            $category_select[$k->id] = $k->title;
        }

        return View::make('admin.news_edit')->with('news', $news)->with('category_select', $category_select);
    }

    public function showComment()
    {
        $paginateNumber = 10;

        $comments = NewsComment::orderBy('datetime', 'DESC')->paginate($paginateNumber);

        $data = array(
            'type' => 'news',
            'comments' => $comments,
        );

        return View::make('admin.comment', $data);
    }

    public function showCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = NewsComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('admin.news.comment');
        }

        $data = array(
            'type' => 'news',
            'comment' => $comment,
        );

        return View::make('admin.comment_edit', $data);
    }

    public function submitNew()
    {
        $config = Config::get('upload');

        $input = Input::only('title', 'category_id', 'summary', 'ckeditor');
        $input['title'] = addslashes(strip_tags($input['title']));
        $input['category_id'] = addslashes(strip_tags($input['category_id']));
        $input['summary'] = strip_tags($input['summary'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'title' => 'required|max:255',
            'category_id' => 'required|max:255',
            'ckeditor' => 'required',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.news.new')->withErrors($validator)->withInput($input);
        }

        // 对图片进行处理
        $input['picture'] = Input::file('picture');
        $filename = '';
        if (!is_null($input['picture'])) {
            if ($input['picture']->getError()) {
                Session::flash('error', $input['picture']->getErrorMessage());
                return Redirect::route('admin.news.new')->withInput(Input::except('picture'));
            }

            $destination = $config['news.picture'];
            do {
                $filename = str_random(64);
            } while (file_exists($destination.$filename));

            $mime = $input['picture']->getMimeType();
            if ($mime !== 'image/gif' && $mime !== 'image/jpeg' && $mime !== 'image/png') {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('admin.news.new')->withInput(Input::except('picture'));
            }

            $mime = $input['picture']->getMimeType();
            if ($mime === 'image/gif') {
                $filename .= '.gif';
            } elseif ($mime === 'image/jpeg') {
                $filename .= '.jpg';
            } elseif ($mime === 'image/png') {
                $filename .= '.png';
            } else {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('admin.news.new')->withInput(Input::except('picture'));
            }

            try {
                $input['picture']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('admin.news.new')->withInput(Input::except('picture'));
            }

//            $img = Image::make($destination.$filename);
//            $img->resize(526, 320)->save($destination.$filename.'-526x320');
//            $img->resize(160, 110)->save($destination.$filename.'-160x110');
//            $img->resize(60, 60)->save($destination.$filename.'-60x60');
        }

        $news = new News;
        $news->title = $input['title'];
        $news->category_id = $input['category_id'];
        if (!is_null($input['picture'])) {
            $news->picture = $filename;
        } else {
            $news->picture = $config['news.picture.default'];
        }
        $news->summary = $input['summary'];
        $news->content = $input['ckeditor'];
        $news->datetime = date("Y-m-d H:i:s");
        $news->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加 '.$input['title']);
        return Redirect::route('admin.news');
    }

    public function submitEdit($id)
    {
        $config = Config::get('upload');

        $id = intval($id);
        try {
            $news = News::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的新闻信息');
            return Redirect::route('admin.news');
        }

        $input = Input::only('title', 'category_id', 'summary', 'ckeditor');
        $input['title'] = addslashes(strip_tags($input['title']));
        $input['category_id'] = addslashes(strip_tags($input['category_id']));
        $input['summary'] = strip_tags($input['summary'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'title' => 'required|max:255',
            'category_id' => 'max:255',
            'ckeditor' => 'required',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.news.edit', $news->id)->withErrors($validator)->withInput($input);
        }

        // 对图片进行处理
        $input['picture'] = Input::file('picture');
        $filename = '';
        if (!is_null($input['picture'])) {
            if ($input['picture']->getError()) {
                Session::flash('error', $input['picture']->getErrorMessage());
                return Redirect::route('admin.news.edit', $news->id)->withInput(Input::except('picture'));
            }

            $destination = $config['news.picture'];
            do {
                $filename = str_random(64);
            } while (file_exists($destination.$filename));

            $mime = $input['picture']->getMimeType();
            if ($mime === 'image/gif') {
                $filename .= '.gif';
            } elseif ($mime === 'image/jpeg') {
                $filename .= '.jpg';
            } elseif ($mime === 'image/png') {
                $filename .= '.png';
            } else {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('admin.news.edit', $news->id)->withInput(Input::except('picture'));
            }

            try {
                $input['picture']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('admin.news.edit', $news->id)->withInput(Input::except('picture'));
            }

//            $img = Image::make($destination.$filename);
//            $img->resize(526, 320)->save($destination.$filename.'-526x320');
//            $img->resize(160, 110)->save($destination.$filename.'-160x110');
//            $img->resize(60, 60)->save($destination.$filename.'-60x60');
        }

        $news->title = $input['title'];
        $news->category_id = $input['category_id'];
        if (!is_null($input['picture'])) {
            $news->picture = $filename;
        }
        $news->summary = $input['summary'];
        $news->content = $input['ckeditor'];
        $news->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑 '.$input['title']);
        return Redirect::route('admin.news');
    }

    public function submitCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = NewsComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('admin.news.comment');
        }

        $input = Input::only('content');
        $input['content'] = addslashes(strip_tags($input['content']));

        // 对提交信息进行验证
        $rules = array(
            'content' => 'required|max:2000',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.news.comment.edit', $comment->id)->withErrors($validator)->withInput($input);
        }

        $comment->content = $input['content'];
        $comment->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑该条评论');
        return Redirect::route('admin.news.comment');
    }

    public function ajaxDeleteNews($id = null)
    {
        $id = intval($id);

        try {
            $news = News::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $news->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条新闻记录');

        return Response::json(array(
            'code' => 0,
        ));
    }

    public function ajaxCommentDelete($id = null)
    {
        $id = intval($id);

        try {
            $comment = NewsComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
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
