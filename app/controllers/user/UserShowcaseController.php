<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserShowcaseController extends BaseController {

    public function __construct() {
        View::composer(array('user.showcase', 'user.showcase_edit'), function($view)
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
        $showcases = Showcase::where('user_id', '=', Sentry::getUser()->getId())->orderBy('datetime', 'DESC')->paginate($paginateNumber);

        return View::make('user.showcase')->with('showcases', $showcases);
    }

    public function showNew()
    {
        // 生成分类列表，供view使用
        $category = ShowcaseCategory::all();
        $category_select = array();
        foreach ($category as $k) {
            $category_select[$k->id] = $k->title;
        }

        $data = array(
            'category_select' => $category_select,
        );

        return View::make('user.showcase_edit', $data);
    }

    public function showEdit($id)
    {
        $id = intval($id);

        try {
            $showcase = Showcase::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的项目信息');
            return Redirect::route('user.showcase');
        }

        if ($showcase->user_id !== Sentry::getUser()->getId()) {
            Session::flash('status', 'danger');
            Session::flash('message', '您没有修改该项目的权限');
            return Redirect::route('user.showcase');
        }

        // 生成分类列表，供view使用
        $category = ShowcaseCategory::all();
        $category_select = array();
        foreach ($category as $k) {
            $category_select[$k->id] = $k->title;
        }

        $data = array(
            'showcase' => $showcase,
            'category_select' => $category_select,
        );

        return View::make('user.showcase_edit', $data);
    }

    public function submitNew()
    {
        $input = Input::only('name', 'company', 'contact_person', 'contact_email', 'contact_phone', 'category_id', 'operation_time', 'summary', 'ckeditor');
        $input['name'] = addslashes(strip_tags($input['name']));
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
            return Redirect::route('user.showcase.new')->withErrors($validator)->withInput($input);
        }

        // 对Logo图片进行处理
        $input['logo'] = Input::file('logo');
        $filename = '';
        $config = Config::get('upload', array('showcase.logo', 'showcase.logo.default'));
        if (!is_null($input['logo'])) {
            if ($input['logo']->getError()) {
                Session::flash('error', $input['logo']->getErrorMessage());
                return Redirect::route('user.showcase.new')->withInput(Input::except('logo'));
            }

            $destination = $config['showcase.logo'];
            do {
                $filename = str_random(64);
            } while (file_exists($destination.$filename));

            $mime = $input['logo']->getMimeType();
            if ($mime !== 'image/gif' && $mime !== 'image/jpeg' && $mime !== 'image/png') {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('user.showcase.new')->withInput(Input::except('logo'));
            }

            try {
                $input['logo']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('user.showcase.new')->withInput(Input::except('logo'));
            }

//            $img = Image::make($destination.$filename);
//            $img->resize(526, 320)->save($destination.$filename.'-526x320');
//            $img->resize(140, 140)->save($destination.$filename.'-140x140');
        }

        $showcase = new Showcase;
        $showcase->user_id = Sentry::getUser()->getId();
        $showcase->name = $input['name'];
        if (!is_null($input['logo'])) {
            $showcase->logo = $filename;
        } else {
            $showcase->logo = $config['showcase.logo.default'];
        }
        $showcase->company = $input['company'];
        $showcase->contact_person = $input['contact_person'];
        $showcase->contact_email = $input['contact_email'];
        $showcase->contact_phone = $input['contact_phone'];
        $showcase->category_id = $input['category_id'];
        $showcase->operation_time = $input['operation_time'];
        $showcase->summary = $input['summary'];
        $showcase->content = $input['ckeditor'];
        $showcase->datetime = date("Y-m-d H:i:s");
        $showcase->vote = 0;
        $showcase->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加 '.$input['name']);
        return Redirect::route('user.showcase');
    }

    public function submitEdit($id)
    {
        $id = intval($id);
        try {
            $showcase = Showcase::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的项目信息');
            return Redirect::route('user.showcase');
        }

        if ($showcase->user_id !== Sentry::getUser()->getId()) {
            Session::flash('status', 'danger');
            Session::flash('message', '您没有修改该项目的权限');
            return Redirect::route('user.showcase');
        }

        $input = Input::only('name', 'company', 'contact_person', 'contact_email', 'contact_phone', 'category_id', 'operation_time', 'summary', 'ckeditor');
        $input['name'] = addslashes(strip_tags($input['name']));
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
            return Redirect::route('user.showcase.edit', $showcase->id)->withErrors($validator)->withInput($input);
        }

        // 对Logo图片进行处理
        $input['logo'] = Input::file('logo');
        $filename = '';
        $config = Config::get('upload', array('showcase.logo', 'showcase.logo.default'));
        if (!is_null($input['logo'])) {
            if ($input['logo']->getError()) {
                Session::flash('error', $input['logo']->getErrorMessage());
                return Redirect::route('user.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }

            $destination = $config['showcase.logo'];
            do {
                $filename = str_random(64);
            } while (file_exists($destination.$filename));

            $mime = $input['logo']->getMimeType();
            if ($mime !== 'image/gif' && $mime !== 'image/jpeg' && $mime !== 'image/png') {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('user.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }

            try {
                $input['logo']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('user.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }

//            $img = Image::make($destination.$filename);
//            $img->resize(526, 320)->save($destination.$filename.'-526x320');
//            $img->resize(140, 140)->save($destination.$filename.'-140x140');
        }

        $showcase->name = $input['name'];
        if (!is_null($input['logo'])) {
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
        return Redirect::route('user.showcase');
    }

}
