<?php

class AccountController extends BaseController {

    public function showLogin()
    {
        if (Sentry::check()) {
            return Redirect::route('home');
        }

        $data = Input::old();

        return View::make('login', $data);
    }

    public function showRegister()
    {
        if (Sentry::check()) {
            return Redirect::route('home');
        }

        $data = Input::old();

        return View::make('register', $data);
    }

    public function showLogout()
    {
        Sentry::logout();

        return Redirect::route('home');
    }

    public function showActive()
    {
        $data = array();

        if (Sentry::check()) {
            $data['error'] = '您当前已登陆，激活无效';
            return View::make('active', $data);
        }

        $input = Input::only('id', 'code');
        if (empty($input['id']) || empty($input['code']) || $input['id'] != intval($input['id'])) {
            $data['error'] = '激活链接无效';
            return View::make('active', $data);
        }
        $input['id'] = intval($input['id']);

        try {
            $user = Sentry::findUserById($input['id']);
            $group = Sentry::findGroupByName('normal');

            if ($user->attemptActivation($input['code'])) {
                $user->addGroup($group);
                $data['error'] = '您的账户已成功激活';
            } else {
                $data['error'] = '激活链接无效';
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $data['error'] = '激活链接无效，该用户未找到';
        } catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
            $data['error'] = '激活链接无效，该用户已经被激活，请直接登陆';
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            $data['error'] = '用户组未找到，请联系管理员';
        } finally {
            return View::make('active', $data);
        }
    }

    public function showForgotten()
    {
        if (Sentry::check()) {
            return Redirect::route('home');
        }

        $data = Input::old();

        return View::make('forgotten', $data);
    }

    public function showForgottenReset()
    {
        if (Session::has('success') || Session::has('error')) {
            if (Sentry::check()) {
                return Redirect::route('home');
            }

            return View::make('forgotten_reset');
        } else {
            $data = array();

            if (Sentry::check()) {
                $data['error'] = '您当前已登陆，重置无效';
                return View::make('forgotten_reset', $data);
            }

            $input = Input::only('id', 'code');
            if (empty($input['id']) || empty($input['code']) || $input['id'] != intval($input['id'])) {
                $data['error'] = '重置链接无效';
                return View::make('forgotten_reset', $data);
            }
            $input['id'] = intval($input['id']);

            try {
                $user = Sentry::findUserById($input['id']);

                if ($user->checkResetPasswordCode($input['code'])) {
                    $data['success'] = '重置链接验证成功';
                    $data['id'] = $input['id'];
                    $data['code'] = $input['code'];
                    return View::make('forgotten_reset', $data);
                } else {
                    $data['error'] = '重置链接无效';
                    return View::make('forgotten_reset', $data);
                }
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                $data['error'] = '用户名不存在';
                return View::make('forgotten_reset', $data);
            }
        }
    }

    public function submitLogin()
    {
        $input = Input::only('username', 'password', 'remember');

        try {
            $credentials = array(
                'username' => $input['username'],
                'password' => $input['password'],
            );

            if (empty($input['remember'])) {
                $user = Sentry::authenticate($credentials, false);
            } elseif ($input['remember'] === 'on') {
                $user = Sentry::authenticate($credentials, true);
            }

            return Redirect::route('home');
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            Session::flash('error', '用户名不能为空');
            return Redirect::route('login')->withInput(Input::except('password'));
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            Session::flash('error', '密码不能为空');
            return Redirect::route('login')->withInput(Input::except('password'));
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            Session::flash('error', '密码错误，请重试');
            return Redirect::route('login')->withInput(Input::except('password'));
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('error', '用户名不存在');
            return Redirect::route('login')->withInput(Input::except('password'));
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            Session::flash('error', '您尚未激活您的账户，请检查您的邮箱中的激活链接');
            return Redirect::route('login')->withInput(Input::except('password'));
        }
    }

    public function submitRegister()
    {
        $input = Input::only('username', 'email', 'password');

        if (empty($input['email'])) {
            Session::flash('error', '电子邮件不能为空');
            return Redirect::route('register')->withInput(Input::except('password'));
        }

        try {
            $user = Sentry::register(array(
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => $input['password'],
            ));

            $data = array('id' => $user->id, 'code' => $user->getActivationCode());
            Mail::queue('emails.auth.active', $data, function($message) use($input)
            {
                $message->to($input['email'], $input['username'])->subject('激活邮件');
            });

            Session::flash('success', '您已成功注册，请点击您邮箱中的链接来激活此账户');
            return Redirect::route('register');
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            Session::flash('error', '用户名不能为空');
            return Redirect::route('register')->withInput(Input::except('password'));
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            Session::flash('error', '密码不能为空');
            return Redirect::route('register')->withInput(Input::except('password'));
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            Session::flash('error', '该用户名已存在');
            return Redirect::route('register')->withInput(Input::except('password'));
        }
    }

    public function submitForgotten()
    {
        $input = Input::only('username');

        try {
            $user = Sentry::findUserByLogin($input['username']);

            $data = array('id' => $user->id, 'code' => $user->getResetPasswordCode());
            Mail::queue('emails.auth.reminder', $data, function($message) use($user)
            {
                $message->to($user->email, $user->username)->subject('重置密码邮件');
            });

            Session::flash('success', '重置密码链接已经发到您的邮箱，请注意查收');
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('error', '您输入的用户名不存在');
        } finally {
            return Redirect::route('forgotten')->withInput(Input::all());
        }
    }

    public function submitForgottenReset()
    {
        $input = Input::only('id', 'code', 'password');

        try {
            $user = Sentry::findUserById($input['id']);

            if ($user->checkResetPasswordCode($input['code'])) {
                if ($user->attemptResetPassword($input['code'], $input['password'])) {
                    Session::flash('success', '您已成功重置密码');
                    return Redirect::route('forgotten_reset');
                } else {
                    Session::flash('error', '出现意外错误，未成功重置密码，请重试');
                    return Redirect::route('forgotten_reset');
                }
            } else {
                Session::flash('error', '重置链接无效');
                return Redirect::route('forgotten_reset');
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('error', '用户名不存在');
            return Redirect::route('forgotten_reset');
        }
    }

}
