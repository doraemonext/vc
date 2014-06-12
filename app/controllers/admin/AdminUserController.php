<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AdminUserController extends BaseController {

    public function __construct() {
        View::composer(array(
            'admin.user',
            'admin.user_edit',
        ), function($view)
        {
            $view->with('user', Sentry::getUser());
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showUser()
    {
        $paginateNumber = 10;
        $input = Input::only('search');

        // 对排序关键字及顺序进行错误处理
        if (!is_null($input['search'])) {
            $input['search'] = addslashes($input['search']);
        }

        // 在数据库中进行查询
        if (is_null($input['search'])) {
            $users = User::orderBy('created_at', 'DESC')->paginate($paginateNumber);
        } else {
            $users = User::where('username', 'LIKE', '%'.$input['search'].'%')->orderBy('created_at', 'DESC')->paginate($paginateNumber);
        }

        return View::make('admin.user')->with('input', $input)->with('users', $users);
    }

    public function showNew()
    {
        return View::make('admin.user_edit');
    }

    public function showEdit($id)
    {
        $id = intval($id);

        try {
            $user = Sentry::findUserById($id);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的用户信息');
            return Redirect::route('admin.user');
        }
        return View::make('admin.user_edit')->with('edit_user', $user);
    }

    public function submitNew()
    {
        $input = Input::only('username', 'email', 'password', 'confirm_password', 'group', 'job', 'name', 'contact', 'company', 'website');
        $input['username'] = addslashes(strip_tags($input['username']));
        $input['email'] = addslashes(strip_tags($input['email']));
        $input['group'] = addslashes(strip_tags($input['group']));
        $input['job'] = addslashes(strip_tags($input['job']));
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['contact'] = addslashes(strip_tags($input['contact']));
        $input['company'] = addslashes(strip_tags($input['company']));
        $input['website'] = addslashes(strip_tags($input['website']));

        // 对提交信息进行验证
        $rules = array(
            'username' => 'required|alpha_dash|max:64',
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
            'confirm_password' => 'required|max:255|same:password',
            'group' => 'required|in:admin,normal',
            'job' => 'max:255',
            'name' => 'max:255',
            'contact' => 'max:255',
            'company' => 'max:255',
            'website' => 'url|max:255',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.user.new')->withErrors($validator)->withInput($input);
        }

        try {
            $user = Sentry::createUser(array(
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => $input['password'],
                'activated' => true,

                'job' => $input['job'],
                'name' => $input['name'],
                'contact' => $input['contact'],
                'company' => $input['company'],
                'website' => $input['website'],
            ));

            $group = Sentry::findGroupByName($input['group']);
            $user->addGroup($group);
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            Session::flash('error', '您必须填写用户名');
            return Redirect::route('admin.user.new')->withInput(Input::all());
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            Session::flash('error', '您必须填写密码');
            return Redirect::route('admin.user.new')->withInput(Input::all());
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            Session::flash('error', '该用户名已存在');
            return Redirect::route('admin.user.new')->withInput(Input::all());
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            Session::flash('error', '用户组未找到，请检查您的用户权限设置');
            return Redirect::route('admin.user.new')->withInput(Input::all());
        }

        Session::flash('status', 'success');
        Session::flash('message', '您已成功添加 '.$input['username']);
        return Redirect::route('admin.user');
    }

    public function submitEdit($id)
    {
        $id = intval($id);

        try {
            $user = Sentry::findUserById($id);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('status', 'danger');
            Session::flash('message', '找不到您要编辑的用户信息');
            return Redirect::route('admin.user');
        }

        $input = Input::only('username', 'email', 'password', 'confirm_password', 'group', 'job', 'name', 'contact', 'company', 'website');
        $input['username'] = addslashes(strip_tags($input['username']));
        $input['email'] = addslashes(strip_tags($input['email']));
        $input['group'] = addslashes(strip_tags($input['group']));
        $input['job'] = addslashes(strip_tags($input['job']));
        $input['name'] = addslashes(strip_tags($input['name']));
        $input['contact'] = addslashes(strip_tags($input['contact']));
        $input['company'] = addslashes(strip_tags($input['company']));
        $input['website'] = addslashes(strip_tags($input['website']));

        // 对提交信息进行验证
        $rules = array(
            'username' => 'required|alpha_dash|max:64',
            'email' => 'required|email|max:255',
            'password' => 'max:255',
            'confirm_password' => 'max:255|same:password',
            'group' => 'required|in:admin,normal',
            'job' => 'max:255',
            'name' => 'max:255',
            'contact' => 'max:255',
            'company' => 'max:255',
            'website' => 'url|max:255',
        );
        $validator = Validator::make($input, $rules, Config::get('validation'));
        if ($validator->fails()) {
            return Redirect::route('admin.user.edit', $id)->withErrors($validator)->withInput(Input::all());
        }

        try {
            $user = Sentry::findUserById($id);
            $group = Sentry::findGroupByName($input['group']);

            $user->removeGroup(Sentry::findGroupByName('admin'));
            if (!$user->addGroup($group)) {
                Session::flash('error', '编辑用户时发生意外错误，请重试');
                return Redirect::route('admin.user.edit', $id)->withInput(Input::all());
            }

            $user->username = $input['username'];
            $user->email = $input['email'];
            if (!empty($input['password'])) {
                $user->password = $input['password'];
            }

            $user->job = $input['job'];
            $user->name = $input['name'];
            $user->contact = $input['contact'];
            $user->company = $input['company'];
            $user->website = $input['website'];

            if (!$user->save()) {
                Session::flash('error', '编辑用户时发生意外错误，请重试');
                return Redirect::route('admin.user.edit', $id)->withInput(Input::all());
            }
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            Session::flash('error', '您修改的新用户名在系统中已存在');
            return Redirect::route('admin.user.edit', $id)->withInput(Input::all());
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('error', '没有找到该用户');
            return Redirect::route('admin.user.edit', $id)->withInput(Input::all());
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            Session::flash('error', '用户组未找到，请检查您的用户权限设置');
            return Redirect::route('admin.user.edit', $id)->withInput(Input::all());
        }

        Session::flash('status', 'success');
        Session::flash('message', '您已成功编辑 '.$input['username']);
        return Redirect::route('admin.user');
    }

    public function ajaxDeleteUser($id = null)
    {
        $id = intval($id);

        try {
            $user = Sentry::findUserById($id);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        // 删除VC评论
        $vc_comment = VcComment::where('user_id', '=', $user->id)->get();
        foreach ($vc_comment as $v) {
            $v->vc->comment_count = $v->vc->comment_count - 1;
            $v->vc->save();
            $v->delete();
        }
        // 删除项目评论
        $showcase_comment = ShowcaseComment::where('user_id', '=', $user->id)->get();
        foreach ($showcase_comment as $s) {
            $s->showcase->comment_count = $s->showcase->comment_count - 1;
            $s->showcase->save();
            $s->delete();
        }
        // 删除新闻评论
        $news_comment = NewsComment::where('user_id', '=', $user->id)->get();
        foreach ($news_comment as $n) {
            $n->news->comment_count = $n->news->comment_count - 1;
            $n->news->save();
            $n->delete();
        }
        // 删除讨论区评论
        $discuss_comment = DiscussComment::where('user_id', '=', $user->id)->get();
        foreach ($discuss_comment as $d) {
            $d->discuss->comment_count = $d->discuss->comment_count - 1;
            $d->discuss->save();
            $d->delete();
        }
        // 删除讨论区话题
        $discuss = Discuss::where('user_id', '=', $user->id)->get();
        foreach ($discuss as $d) {
            DiscussComment::where('discuss_id', '=', $d->id)->delete();
            $d->delete();
        }
        // 删除发布的项目
        $showcase = Showcase::where('user_id', '=', $user->id)->get();
        foreach ($showcase as $s) {
            // 删除该项目下的所有评论
            ShowcaseComment::where('showcase_id', '=', $s->id)->delete();
            $s->delete();
        }
        // 删除通知中心中的内容
        // 删除VC评分
        $vc_rating = VcRating::where('user_id', '=', $user->id)->get();
        $vc = array();
        foreach ($vc_rating as $v) {
            array_push($vc, $v->vc_id);
            $v->delete();
        }
        $vc = array_unique($vc);
        foreach ($vc as $v) {
            $now = Vc::find($v);
            $now->rating = Vc::getRatingByVC($v)[0];
            $now->save();
        }

        $user->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该用户');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
