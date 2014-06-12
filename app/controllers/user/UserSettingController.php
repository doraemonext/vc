<?php

class UserSettingController extends BaseController {

    public function __construct() {
        View::composer(array('user.setting'), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('notification', Notification::getNotifications(Sentry::getUser()->getId()));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showSetting()
    {
        return View::make('user.setting');
    }

    public function submitSetting()
    {
        $input = Input::only(
            'old_password',
            'new_password',
            'confirm_password',
            'email',
            'job',
            'name',
            'contact',
            'company',
            'website'
        );

        $input['email'] = addslashes(strip_tags($input['email']));
        $input['job'] = addslashes(strip_tags($input['job']));
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['contact'] = addslashes(strip_tags($input['contact']));
        $input['company'] = addslashes(strip_tags($input['company']));
        $input['website'] = addslashes(strip_tags($input['website']));

        // 对提交信息进行验证
        $rules = array(
            'old_password' => 'required|max:255',
            'new_password' => 'min:6|max:255',
            'confirm_password' => 'min:6|max:255|same:new_password',
            'email' => 'required|email|max:255',
            'job' => 'max:255',
            'name' => 'max:255',
            'contact' => 'max:255',
            'company' => 'max:255',
            'website' => 'url|max:255',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('user.setting')->withErrors($validator)->withInput($input);
        }

        $user = Sentry::getUser();
        // 检查原密码是否匹配
        if (!$user->checkPassword($input['old_password'])) {
            Session::flash('status', 'danger');
            Session::flash('message', '原密码不正确，请重新输入');
            return Redirect::route('user.setting')->withInput($input);
        }

        if (!empty($input['new_password'])) {
            $user->password = $input['new_password'];
        }
        $user->email = $input['email'];
        $user->job = $input['job'];
        $user->name = $input['name'];
        $user->contact = $input['contact'];
        $user->company = $input['company'];
        $user->website = $input['website'];
        $user->save();

        Session::flash('status', 'success');
        Session::flash('message', '您已成功更新个人信息');
        return Redirect::route('user.setting');
    }

}
