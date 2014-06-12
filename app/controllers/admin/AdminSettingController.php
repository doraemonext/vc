<?php

class AdminSettingController extends BaseController {

    public function __construct() {
        View::composer(array('admin.setting'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showSetting()
    {
        return View::make('admin.setting');
    }

    public function submitSetting()
    {
        $input = Input::only(
            'title',
            'description'
        );

        $input['title'] = addslashes(strip_tags($input['title']));
        $input['description'] = addslashes(strip_tags($input['description']));

        // 对提交信息进行验证
        $rules = array(
            'title' => 'required|max:255',
            'description' => 'min:6|max:255',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.setting')->withErrors($validator)->withInput($input);
        }

        $title = Setting::where('title', '=', 'title')->get()->first();
        $title->value = $input['title'];
        $title->save();
        $description = Setting::where('title', '=', 'description')->get()->first();
        $description->value = $input['description'];
        $description->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功更新系统设置');
        return Redirect::route('admin.setting');
    }

}
