<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AdminShowcaseController extends BaseController {

    public function __construct() {
        View::composer(array(
            'admin.showcase',
            'admin.showcase_edit',
        ), function($view)
        {
            $view->with('user', Sentry::getUser());
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
            } while (file_exists('public/'.$destination.$filename));

            $mime = $input['logo']->getMimeType();
            if ($mime !== 'image/gif' && $mime !== 'image/jpeg' && $mime !== 'image/png') {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('admin.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }

            $status = $input['logo']->move('public/'.$destination, $filename);
            if (!$status) {
                Session::flash('error', '上传Logo失败，请联系管理员处理');
                return Redirect::route('admin.showcase.edit', $showcase->id)->withInput(Input::except('logo'));
            }
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
        return Redirect::route('admin.showcase');
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

        $showcase->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条项目记录');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
