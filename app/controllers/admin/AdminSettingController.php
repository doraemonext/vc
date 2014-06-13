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
            'description',

            'count_vc',
            'count_user',
            'count_comment'
        );

        $input['title'] = addslashes(strip_tags($input['title']));
        $input['description'] = addslashes(strip_tags($input['description']));
        $input['count_vc'] = intval($input['count_vc']);
        $input['count_user'] = intval($input['count_user']);
        $input['count_comment'] = intval($input['count_comment']);

        // 对提交信息进行验证
        $rules = array(
            'title' => 'required|max:255',
            'description' => 'min:6|max:255',
            'count_vc' => 'max:6',
            'count_user' => 'max:6',
            'count_comment' => 'max:6',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.setting')->withErrors($validator);
        }

        $title = Setting::where('title', '=', 'title')->get()->first();
        $title->value = $input['title'];
        $title->save();
        $description = Setting::where('title', '=', 'description')->get()->first();
        $description->value = $input['description'];
        $description->save();
        $count_vc = Setting::where('title', '=', 'count_vc')->get()->first();
        $count_vc->value = $input['count_vc'];
        $count_vc->save();
        $count_user = Setting::where('title', '=', 'count_user')->get()->first();
        $count_user->value = $input['count_user'];
        $count_user->save();
        $count_comment = Setting::where('title', '=', 'count_comment')->get()->first();
        $count_comment->value = $input['count_comment'];
        $count_comment->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功更新系统设置');
        return Redirect::route('admin.setting');
    }

}
