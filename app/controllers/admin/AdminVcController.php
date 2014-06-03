<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AdminVcController extends BaseController {

    public function __construct() {
        View::composer(array(
            'admin.vc',
            'admin.vc_edit',
        ), function($view)
        {
            $view->with('user', Sentry::getUser());
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

        return View::make('admin.vc')->with('input', $input)->with('vcs', $vcs);
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

    public function submitNew()
    {
        $input = Input::only('name', 'invest_field', 'invest_scale', 'website', 'summary', 'ckeditor');
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['invest_field'] = addslashes(strip_tags($input['invest_field']));
        $input['invest_scale'] = addslashes(strip_tags($input['invest_scale']));
        $input['website'] = addslashes(strip_tags($input['website']));
        $input['summary'] = strip_tags($input['summary'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'name' => 'required|max:255',
            'invest_field' => 'max:255',
            'invest_scale' => 'max:255',
            'website' => 'url|max:255',
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
            } while (file_exists('public/'.$destination.$filename));

            $mime = $input['logo']->getMimeType();
            if ($mime !== 'image/gif' && $mime !== 'image/jpeg' && $mime !== 'image/png') {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('admin.vc.new')->withInput(Input::except('logo'));
            }

            $status = $input['logo']->move('public/'.$destination, $filename);
            if (!$status) {
                Session::flash('error', '上传Logo失败，请联系管理员处理');
                return Redirect::route('admin.vc.new')->withInput(Input::except('logo'));
            }
        }

        $vc = new Vc;
        $vc->name = $input['name'];
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

        $input = Input::only('name', 'invest_field', 'invest_scale', 'website', 'summary', 'ckeditor');
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['invest_field'] = addslashes(strip_tags($input['invest_field']));
        $input['invest_scale'] = addslashes(strip_tags($input['invest_scale']));
        $input['website'] = addslashes(strip_tags($input['website']));
        $input['summary'] = strip_tags($input['summary'], '<br>');

        // 对提交信息进行验证
        $rules = array(
            'name' => 'required|max:255',
            'invest_field' => 'max:255',
            'invest_scale' => 'max:255',
            'website' => 'url|max:255',
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
            } while (file_exists('public/'.$destination.$filename));

            $mime = $input['logo']->getMimeType();
            if ($mime !== 'image/gif' && $mime !== 'image/jpeg' && $mime !== 'image/png') {
                Session::flash('error', '您上传的不是图片文件');
                return Redirect::route('admin.vc.edit', $vc->id)->withInput(Input::except('logo'));
            }

            $status = $input['logo']->move('public/'.$destination, $filename);
            if (!$status) {
                Session::flash('error', '上传Logo失败，请联系管理员处理');
                return Redirect::route('admin.vc.edit', $vc->id)->withInput(Input::except('logo'));
            }
        }

        $vc->name = $input['name'];
        if (!is_null($input['logo'])) {
            $vc->logo = $filename;
        }
        $vc->invest_field = $input['invest_field'];
        $vc->invest_scale = $input['invest_scale'];
        $vc->website = $input['website'];
        $vc->summary = $input['summary'];
        $vc->content = $input['ckeditor'];
        $vc->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑 '.$input['name']);
        return Redirect::route('admin.vc');
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

        $vc->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条VC记录');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
