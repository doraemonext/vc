<?php

class AccountController extends BaseController {

    public function showLogin()
    {
        $data = Input::old();

        return View::make('login', $data);
    }

    public function showRegister()
    {
        $data = Input::old();

        return View::make('register', $data);
    }

    public function submitLogin()
    {
        $input = Input::only('username', 'password', 'remember');

        try {
            $credentials = array(
                'username' => $input['username'],
                'password' => $input['password'],
            );

            if (is_null($input['remember'])) {
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

            $activationCode = $user->getActivationCode();

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

}
