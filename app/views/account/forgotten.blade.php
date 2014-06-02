@extends('account.templates.base_clean')

@section('header')
    @parent
    <span id="login-header-space"> <span class="hidden-mobile">需要一个账户？</span> <a href="{{ route('register') }}" class="btn btn-danger">注册一个新账户</a> </span>
@stop

@section('content')
    @parent
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
        <div class="well no-padding">
            {{ Form::open(array('action' => 'AccountController@submitForgotten', 'id' => 'login-form', 'class' => 'smart-form client-form')) }}
                <header>忘记密码</header>
                <fieldset>
                    <section>
                        <label class="label">用户名</label>
                        <label class="input"> <i class="icon-append fa fa-user"></i>
                            {{ Form::text('username', isset($username) ? $username : '') }}
                            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> 请输入您的用户名</b></label>
                    </section>
                    <section>
                        <section>
                            <label class="label">电子邮箱</label>
                            <label class="input"> <i class="icon-append fa fa-envelope"></i>
                                {{ Form::email('email', isset($email) ? $email : '') }}
                                <b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> 请输入您注册时的电子邮箱</b> </label>
                                <div class="note">
                                    <a href="{{ route('login') }}">我记得我的密码，点此进行登录</a>
                                </div>

                                @if ($errors->count() > 0)
                                <br>
                                <div class="alert alert-danger fade in">
                                    @foreach ($errors->all('<li>:message</li>') as $message)
                                        {{ $message }}
                                    @endforeach
                                </div>
                                @endif

                                @if (Session::has('error'))
                                <br>
                                <div class="alert alert-danger fade in">
                                    <li>{{ Session::get('error') }}</li>
                                </div>
                                @endif
                                @if (Session::has('success'))
                                <br>
                                <div class="alert alert-success fade in">
                                    <li>{{ Session::get('success') }}</li>
                                </div>
                                @endif
                        </section>
                </fieldset>
                @if (!Session::has('success'))
                <footer>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-refresh"></i> 重置密码
                    </button>
                </footer>
                @endif
            {{ Form::close() }}
        </div>
    </div>
@stop
