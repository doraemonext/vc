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
            @if (isset($success))
                {{ Form::open(array('action' => 'AccountController@submitForgottenReset', 'id' => 'login-form', 'class' => 'smart-form client-form')) }}
                    {{ Form::hidden('id', $id) }}
                    {{ Form::hidden('code', $code) }}

                    <header>重置密码</header>
                    <fieldset>
                        <section>
                            <label class="label">新密码</label>
                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                {{ Form::password('password') }}
                                <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> 请输入您的新密码</b></label>
                        </section>
                        <section>
                            <section>
                                <label class="label">确认新密码</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    {{ Form::password('confirm_password') }}
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> 请重新输入您的新密码</b> </label>

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
                            </section>
                    </fieldset>
                    <footer>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-refresh"></i> 重置密码
                        </button>
                    </footer>
                {{ Form::close() }}
            @elseif (isset($error) || Session::has('error'))
                {{ Form::open(array('id' => 'login-form', 'class' => 'smart-form client-form')) }}
                    <header>重置密码</header>
                    <fieldset>
                        <section>
                            <label class="label">新密码</label>
                            <label class="input state-error"> <i class="icon-append fa fa-lock"></i>
                                {{ Form::text('password', '', array('disabled')) }}
                            </label>
                        </section>
                        <section>
                            <section>
                                <label class="label">确认新密码</label>
                                <label class="input state-error"> <i class="icon-append fa fa-lock"></i>
                                    {{ Form::text('confirm_password', '', array('disabled')) }}
                                </label>

                                @if (isset($error))
                                <br>
                                <div class="alert alert-danger fade in">
                                    <li>{{ $error }}</li>
                                </div>
                                @endif

                                @if (Session::has('error'))
                                <br>
                                <div class="alert alert-danger fade in">
                                    <li>{{ Session::get('error') }}</li>
                                </div>
                                @endif
                            </section>
                    </fieldset>
                    <footer>
                        <button type="button" class="btn btn-primary" disabled="disabled">
                            <i class="fa fa-refresh"></i> 重置密码
                        </button>
                    </footer>
                {{ Form::close() }}
            @endif
        </div>
    </div>
@stop
