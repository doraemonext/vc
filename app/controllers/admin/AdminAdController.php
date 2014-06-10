<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminAdController extends BaseController {

    public function __construct() {
        View::composer(array('admin.ad', 'admin.ad_edit'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
        });
    }

    public function showAd()
    {
        $paginateNumber = 10;

        $ads = Ad::orderBy('position_id')->orderBy('id')->paginate($paginateNumber);

        $data = array(
            'ads' => $ads,
        );

        return View::make('admin.ad', $data);
    }

    public function showNew()
    {
        return View::make('admin.ad_edit');
    }

    public function showEdit($id)
    {
        $id = intval($id);

        try {
            $ad = Ad::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的广告信息');
            return Redirect::route('admin.ad');
        }

        $data = array(
            'ad' => $ad,
        );

        return View::make('admin.ad_edit', $data);
    }

    public function submitNew()
    {
        $config = Config::get('upload');

        $input = Input::only('url');
        $input['url'] = addslashes(strip_tags($input['url']));

        // 对提交信息进行验证
        $rules = array(
            'url' => 'required|url',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.ad.new')->withErrors($validator)->withInput($input);
        }

        // 对图片进行处理
        $input['picture'] = Input::file('picture');
        $filename = '';
        if (is_null($input['picture'])) {
            Session::flash('error', '您必须要上传一张图片');
            return Redirect::route('admin.ad.new')->withInput(Input::except('picture'));
        } else {
            if ($input['picture']->getError()) {
                Session::flash('error', $input['picture']->getErrorMessage());
                return Redirect::route('admin.ad.new')->withInput(Input::except('picture'));
            }

            $destination = $config['ad.picture'];
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
                return Redirect::route('admin.ad.new')->withInput(Input::except('picture'));
            }

            try {
                $input['picture']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('admin.ad.new')->withInput(Input::except('picture'));
            }
        }

        $ad = new Ad;
        $ad->picture = $filename;
        $ad->url = $input['url'];
        $ad->position_id = 1;
        $ad->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加该广告');
        return Redirect::route('admin.ad');
    }

    public function submitEdit($id)
    {
        $config = Config::get('upload');

        $id = intval($id);
        try {
            $ad = Ad::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的广告信息');
            return Redirect::route('admin.ad');
        }

        $input = Input::only('url');
        $input['url'] = addslashes(strip_tags($input['url']));

        // 对提交信息进行验证
        $rules = array(
            'url' => 'required|url',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.ad.edit', $ad->id)->withErrors($validator)->withInput($input);
        }

        // 对图片进行处理
        $input['picture'] = Input::file('picture');
        $filename = '';
        if (!is_null($input['picture'])) {
            if ($input['picture']->getError()) {
                Session::flash('error', $input['picture']->getErrorMessage());
                return Redirect::route('admin.ad.edit', $ad->id)->withInput(Input::except('picture'));
            }

            $destination = $config['ad.picture'];
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
                return Redirect::route('admin.ad.edit', $ad->id)->withInput(Input::except('picture'));
            }

            try {
                $input['picture']->move($destination, $filename);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::route('admin.ad.edit', $ad->id)->withInput(Input::except('picture'));
            }
        }

        if (!is_null($input['picture'])) {
            $ad->picture = $filename;
        }
        $ad->url = $input['url'];
        $ad->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑该广告');
        return Redirect::route('admin.ad');
    }

    public function ajaxAdDelete($id = null)
    {
        $id = intval($id);

        try {
            $ad = Ad::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $ad->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条广告');

        return Response::json(array(
            'code' => 0,
        ));
    }

}

