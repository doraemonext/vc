@extends('account.templates.base_clean')

@section('header')
    @parent
    <span id="login-header-space"> <span class="hidden-mobile">需要一个账户？</span> <a href="{{ route('register') }}" class="btn btn-danger">注册一个新账户</a> </span>
@stop

@section('content')
    @parent
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
        <h1 class="txt-color-red login-header-big">SmartAdmin</h1>
        <div class="hero">
            <div class="pull-left login-desc-box-l">
                <h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SmartAdmin, everywhere you go!</h4>
                <div class="login-app-icons">
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
                </div>
            </div>
            <img src="{{ asset('smartadmin/img/demo/iphoneview.png') }}" class="pull-right display-image" alt="" style="width:210px">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
        <div class="well no-padding">
            {{ Form::open(array('action' => 'AccountController@submitLogin', 'id' => 'login-form', 'class' => 'smart-form client-form')) }}
                <header>登陆</header>
                <fieldset>
                    <section>
                        <label class="label">用户名</label>
                        <label class="input"> <i class="icon-append fa fa-user"></i>
                            {{ Form::text('username', isset($username) ? $username : '') }}
                            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> 请输入您的用户名</b></label>
                    </section>
                    <section>
                        <label class="label">密码</label>
                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                            {{ Form::password('password') }}
                            <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> 请输入您的密码</b> </label>

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

                            <div class="note">
                                <a href="{{ route('forgotten') }}">忘记密码了？</a>
                            </div>
                    </section>
                    <section>
                        <label class="checkbox">
                            @if (isset($remember) && $remember === 'on')
                                {{ Form::checkbox('remember', 'on', true) }}
                            @else
                                {{ Form::checkbox('remember', 'on') }}
                            @endif
                            <i></i>下次自动登陆</label>


                            @if (Session::has('success'))
                            <br>
                            <div class="alert alert-success fade in">
                                <li>{{ Session::get('success') }}</li>
                            </div>
                            @endif
                    </section>
                </fieldset>
                <footer>
                    <button type="submit" class="btn btn-primary">登陆</button>
                </footer>
            {{ Form::close() }}
        </div>
    </div>
@stop
