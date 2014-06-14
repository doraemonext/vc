<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AdminVcController extends BaseController {

    public function __construct() {
        View::composer(array(
            'admin.vc',
            'admin.vc_edit',
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

    public function showVc()
    {
        $paginateNumber = 10;
        $input = Input::only('search', 'order_by', 'order');

        // 对排序关键字及顺序进行错误处理
        if (!is_null($input['search'])) {
            $input['search'] = addslashes($input['search']);
        }
        if (!is_null($input['order_by']) && $input['order_by'] !== 'datetime' && $input['order_by'] !== 'rating') {
            $input['order_by'] = 'datetime';
        }
        if (!is_null($input['order']) && $input['order'] !== 'positive' && $input['order'] !== 'negative') {
            $input['order'] = 'negative';
        }
        $input['order_by'] = is_null($input['order_by']) ? 'datetime' : $input['order_by'];
        $input['order'] = is_null($input['order']) ? 'negative' : $input['order'];

        // 在数据库中进行查询
        if (is_null($input['search'])) {
            if ($input['order'] === 'negative') {
                $vcs = Vc::orderBy($input['order_by'], 'DESC')->paginate($paginateNumber);
            } else {
                $vcs = Vc::orderBy($input['order_by'])->paginate($paginateNumber);
            }
        } else {
            if ($input['order'] === 'negative') {
                $vcs = Vc::where('name', 'LIKE', '%'.$input['search'].'%')->orderBy($input['order_by'], 'DESC')->paginate($paginateNumber);
            } else {
                $vcs = Vc::where('name', 'LIKE', '%'.$input['search'].'%')->orderBy($input['order_by'])->paginate($paginateNumber);
            }
        }

        foreach ($vcs as $vc) {
            $vc->score = $this->getRatingByVC($vc->id);
        }

        $data = array(
            'input' => $input,
            'vcs' => $vcs,
            'rating_category' => VcRatingCategory::all(),
        );

        return View::make('admin.vc', $data);
    }

    public function showNew()
    {
        return View::make('admin.vc_edit');
    }

    public function showEdit($id)
    {
        $id = intval($id);

        try {
            $vc = Vc::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的投资方信息');
            return Redirect::route('admin.vc');
        }

        return View::make('admin.vc_edit')->with('vc', $vc);
    }

    public function showComment()
    {
        $paginateNumber = 10;

        $comments = VcComment::orderBy('datetime', 'DESC')->paginate($paginateNumber);

        $data = array(
            'type' => 'vc',
            'comments' => $comments,
        );

        return View::make('admin.comment', $data);
    }

    public function showCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = VcComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('admin.vc.comment');
        }

        $data = array(
            'type' => 'vc',
            'comment' => $comment,
        );

        return View::make('admin.comment_edit', $data);
    }

    public function submitNew()
    {
        $input = Input::only(
            'name',
            'recommended',
            'invest_field',
            'invest_scale',
            'website',
            'summary',
            'ckeditor',
            'showcase_1_title', 'showcase_1_content', 'showcase_1_url',
            'showcase_2_title', 'showcase_2_content', 'showcase_2_url',
            'showcase_3_title', 'showcase_3_content', 'showcase_3_url',
            'showcase_4_title', 'showcase_4_content', 'showcase_4_url',
            'showcase_5_title', 'showcase_5_content', 'showcase_5_url'
        );
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['recommended'] = addslashes(strip_tags($input['recommended']));
        $input['invest_field'] = addslashes(strip_tags($input['invest_field']));
        $input['invest_scale'] = addslashes(strip_tags($input['invest_scale']));
        $input['website'] = addslashes(strip_tags($input['website']));
        $input['summary'] = strip_tags($input['summary'], '<br>');

        $input['showcase_1_title'] = addslashes(strip_tags($input['showcase_1_title']));
        $input['showcase_1_content'] = addslashes(strip_tags($input['showcase_1_content']));
        $input['showcase_1_url'] = addslashes(strip_tags($input['showcase_1_url']));
        $input['showcase_2_title'] = addslashes(strip_tags($input['showcase_2_title']));
        $input['showcase_2_content'] = addslashes(strip_tags($input['showcase_2_content']));
        $input['showcase_2_url'] = addslashes(strip_tags($input['showcase_2_url']));
        $input['showcase_3_title'] = addslashes(strip_tags($input['showcase_3_title']));
        $input['showcase_3_content'] = addslashes(strip_tags($input['showcase_3_content']));
        $input['showcase_3_url'] = addslashes(strip_tags($input['showcase_3_url']));
        $input['showcase_4_title'] = addslashes(strip_tags($input['showcase_4_title']));
        $input['showcase_4_content'] = addslashes(strip_tags($input['showcase_4_content']));
        $input['showcase_4_url'] = addslashes(strip_tags($input['showcase_4_url']));
        $input['showcase_5_title'] = addslashes(strip_tags($input['showcase_5_title']));
        $input['showcase_5_content'] = addslashes(strip_tags($input['showcase_5_content']));
        $input['showcase_5_url'] = addslashes(strip_tags($input['showcase_5_url']));

        // 对提交信息进行验证
        $rules = array(
            'name' => 'required|max:255',
            'recommended' => 'required',
            'invest_field' => 'max:255',
            'invest_scale' => 'max:255',
            'website' => 'url|max:255',

            'showcase_1_title' => 'max:255',
            'showcase_1_content' => 'max:2000',
            'showcase_1_url' => 'url|max:255',
            'showcase_2_title' => 'max:255',
            'showcase_2_content' => 'max:2000',
            'showcase_2_url' => 'url|max:255',
            'showcase_3_title' => 'max:255',
            'showcase_3_content' => 'max:2000',
            'showcase_3_url' => 'url|max:255',
            'showcase_4_title' => 'max:255',
            'showcase_4_content' => 'max:2000',
            'showcase_4_url' => 'url|max:255',
            'showcase_5_title' => 'max:255',
            'showcase_5_content' => 'max:2000',
            'showcase_5_url' => 'url|max:255',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.vc.new')->withErrors($validator)->withInput($input);
        }

        // 对Logo图片进行处理
        $input['logo'] = Input::file('logo');
        $filename = '';
        $config = Config::get('upload', array('vc.logo', 'vc.logo.default'));
        if (!is_null($input['logo'])) {
            if ($input['logo']->getError()) {
                Session::flash('error', $input['logo']->getErrorMessage());
                return Redirect::route('admin.vc.new')->withInput(Input::except('logo'));
            }

            $destination = $config['vc.logo'];
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
                return Redirect::route('admin.vc.new')->withInput(Input::except('logo'));
            }

            try {
                $input['logo']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('admin.vc.new')->withInput(Input::except('logo'));
            }

            $img = Image::make($destination.$filename);
            $img->resize(140, 140);
            $img->save();
        }

        $vc = new Vc;
        $vc->name = $input['name'];
        $vc->recommended = ($input['recommended'] == '1') ? 1 : 0;
        if (!is_null($input['logo'])) {
            $vc->logo = $filename;
        } else {
            $vc->logo = $config['vc.logo.default'];
        }
        $vc->invest_field = $input['invest_field'];
        $vc->invest_scale = $input['invest_scale'];
        $vc->website = $input['website'];
        $vc->summary = $input['summary'];
        $vc->content = $input['ckeditor'];
        $vc->datetime = date("Y-m-d H:i:s");
        $vc->rating = 0.0;
        $vc->save();

        for ($i = 1; $i <= 5; $i++) {
            if (empty($input['showcase_'.strval($i).'_title']) && empty($input['showcase_'.strval($i).'_content']) && empty($input['showcase_'.strval($i).'_url'])) {
                continue;
            }

            $vc_showcase = new VcShowcase;
            $vc_showcase->vc_id = $vc->id;
            $vc_showcase->title = $input['showcase_'.strval($i).'_title'];
            $vc_showcase->content = $input['showcase_'.strval($i).'_content'];
            $vc_showcase->url = $input['showcase_'.strval($i).'_url'];
            $vc_showcase->save();
        }

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加 '.$input['name']);
        return Redirect::route('admin.vc');
    }

    public function submitEdit($id)
    {
        $id = intval($id);
        try {
            $vc = Vc::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的投资方信息');
            return Redirect::route('admin.vc');
        }

        $input = Input::only(
            'name',
            'recommended',
            'invest_field',
            'invest_scale',
            'website',
            'summary',
            'ckeditor',

            'showcase_1_title', 'showcase_1_content', 'showcase_1_url',
            'showcase_2_title', 'showcase_2_content', 'showcase_2_url',
            'showcase_3_title', 'showcase_3_content', 'showcase_3_url',
            'showcase_4_title', 'showcase_4_content', 'showcase_4_url',
            'showcase_5_title', 'showcase_5_content', 'showcase_5_url'
        );
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['recommended'] = addslashes(strip_tags($input['recommended']));
        $input['invest_field'] = addslashes(strip_tags($input['invest_field']));
        $input['invest_scale'] = addslashes(strip_tags($input['invest_scale']));
        $input['website'] = addslashes(strip_tags($input['website']));
        $input['summary'] = strip_tags($input['summary'], '<br>');

        $input['showcase_1_title'] = addslashes(strip_tags($input['showcase_1_title']));
        $input['showcase_1_content'] = addslashes(strip_tags($input['showcase_1_content']));
        $input['showcase_1_url'] = addslashes(strip_tags($input['showcase_1_url']));
        $input['showcase_2_title'] = addslashes(strip_tags($input['showcase_2_title']));
        $input['showcase_2_content'] = addslashes(strip_tags($input['showcase_2_content']));
        $input['showcase_2_url'] = addslashes(strip_tags($input['showcase_2_url']));
        $input['showcase_3_title'] = addslashes(strip_tags($input['showcase_3_title']));
        $input['showcase_3_content'] = addslashes(strip_tags($input['showcase_3_content']));
        $input['showcase_3_url'] = addslashes(strip_tags($input['showcase_3_url']));
        $input['showcase_4_title'] = addslashes(strip_tags($input['showcase_4_title']));
        $input['showcase_4_content'] = addslashes(strip_tags($input['showcase_4_content']));
        $input['showcase_4_url'] = addslashes(strip_tags($input['showcase_4_url']));
        $input['showcase_5_title'] = addslashes(strip_tags($input['showcase_5_title']));
        $input['showcase_5_content'] = addslashes(strip_tags($input['showcase_5_content']));
        $input['showcase_5_url'] = addslashes(strip_tags($input['showcase_5_url']));

        // 对提交信息进行验证
        $rules = array(
            'name' => 'required|max:255',
            'recommended' => 'required',
            'invest_field' => 'max:255',
            'invest_scale' => 'max:255',
            'website' => 'url|max:255',

            'showcase_1_title' => 'max:255',
            'showcase_1_content' => 'max:2000',
            'showcase_1_url' => 'url|max:255',
            'showcase_2_title' => 'max:255',
            'showcase_2_content' => 'max:2000',
            'showcase_2_url' => 'url|max:255',
            'showcase_3_title' => 'max:255',
            'showcase_3_content' => 'max:2000',
            'showcase_3_url' => 'url|max:255',
            'showcase_4_title' => 'max:255',
            'showcase_4_content' => 'max:2000',
            'showcase_4_url' => 'url|max:255',
            'showcase_5_title' => 'max:255',
            'showcase_5_content' => 'max:2000',
            'showcase_5_url' => 'url|max:255',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.vc.edit', $vc->id)->withErrors($validator)->withInput($input);
        }

        // 对Logo图片进行处理
        $input['logo'] = Input::file('logo');
        $filename = '';
        $config = Config::get('upload', array('vc.logo', 'vc.logo.default'));
        if (!is_null($input['logo'])) {
            if ($input['logo']->getError()) {
                Session::flash('error', $input['logo']->getErrorMessage());
                return Redirect::route('admin.vc.edit', $vc->id)->withInput(Input::except('logo'));
            }

            $destination = $config['vc.logo'];
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
                return Redirect::route('admin.vc.edit', $vc->id)->withInput(Input::except('logo'));
            }

            try {
                $input['logo']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('admin.vc.edit', $vc->id)->withInput(Input::except('logo'));
            }

            $img = Image::make($destination.$filename);
            $img->resize(140, 140);
            $img->save();
        }

        $vc->name = $input['name'];
        $vc->recommended = ($input['recommended'] == '1') ? 1 : 0;
        if (!is_null($input['logo'])) {
            if ($vc->logo != 'default.jpg') {
                Croppa::delete($destination.$vc->logo);
            }
            $vc->logo = $filename;
        }
        $vc->invest_field = $input['invest_field'];
        $vc->invest_scale = $input['invest_scale'];
        $vc->website = $input['website'];
        $vc->summary = $input['summary'];
        $vc->content = $input['ckeditor'];
        $vc->save();

        $vc_showcase = VcShowcase::where('vc_id', '=', $vc->id)->get();
        foreach ($vc_showcase as $v) {
            $v->delete();
        }

        for ($i = 1; $i <= 5; $i++) {
            if (empty($input['showcase_'.strval($i).'_title']) && empty($input['showcase_'.strval($i).'_content']) && empty($input['showcase_'.strval($i).'_url'])) {
                continue;
            }

            $vc_showcase = new VcShowcase;
            $vc_showcase->vc_id = $vc->id;
            $vc_showcase->title = $input['showcase_'.strval($i).'_title'];
            $vc_showcase->content = $input['showcase_'.strval($i).'_content'];
            $vc_showcase->url = $input['showcase_'.strval($i).'_url'];
            $vc_showcase->save();
        }

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑 '.$input['name']);
        return Redirect::route('admin.vc');
    }

    public function submitCommentEdit($id)
    {
        $id = intval($id);

        try {
            $comment = VcComment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的评论信息');
            return Redirect::route('admin.vc.comment');
        }

        $input = Input::only('content');
        $input['content'] = addslashes(strip_tags($input['content']));

        // 对提交信息进行验证
        $rules = array(
            'content' => 'required|max:2000',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.vc.comment.edit', $comment->id)->withErrors($validator)->withInput($input);
        }

        $comment->content = $input['content'];
        $comment->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑该条评论');
        return Redirect::route('admin.vc.comment');
    }

    public function ajaxDeleteVc($id = null)
    {
        $id = intval($id);

        try {
            $vc = Vc::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        VcComment::where('vc_id', '=', $vc->id)->delete();
        VcRating::where('vc_id', '=', $vc->id)->delete();
        VcShowcase::where('vc_id', '=', $vc->id)->delete();

        $vc->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条VC记录');

        return Response::json(array(
            'code' => 0,
        ));
    }

    public function ajaxCommentDelete($id = null)
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

        $comment->vc->comment_count = $comment->vc->comment_count - 1;
        $comment->vc->save();

        $comment->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条评论');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
