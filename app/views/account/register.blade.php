@extends('account.templates.base_clean')

@section('page_title')
-注册
@stop

@section('header')
    @parent
    <span id="login-header-space"> <span class="hidden-mobile">已经注册过了？</span> <a href="{{ route('login') }}" class="btn btn-danger">登陆</a> </span>
@stop

@section('content')
    @parent
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 hidden-xs hidden-sm">
        <h1 class="txt-color-red login-header-big">{{ $setting['title'] }}</h1>
        <div class="hero">
            <div class="pull-left login-desc-box-l">
                <h4 class="paragraph-header">{{ $setting['description'] }}</h4>
                <div class="login-app-icons">
                    <a href="{{ route('vc.list') }}" class="btn btn-danger btn-sm">VC展示</a>
                    <a href="{{ route('showcase.list') }}" class="btn btn-danger btn-sm">项目展示</a>
                    <a href="{{ route('discuss.list') }}" class="btn btn-danger btn-sm">讨论区</a>
                    <a href="{{ route('business') }}" class="btn btn-danger btn-sm">商业合作</a>
                </div>
            </div>
            <img src="{{ asset('smartadmin/img/demo/iphoneview.png') }}" class="pull-right display-image" alt="" style="width:210px">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
        <div class="well no-padding">
            {{ Form::open(array('action' => 'AccountController@submitRegister', 'id' => 'smart-form-register', 'class' => 'smart-form client-form')) }}
                <header>注册</header>

                <fieldset>
                    <section>
                        <label class="input"> <i class="icon-append fa fa-user"></i>
                            {{ Form::text('username', isset($username) ? $username : '', array('placeholder' => '用户名')) }}
                            <b class="tooltip tooltip-bottom-right">请输入您的用户名，这将是您登陆网站的凭证</b> </label>
                    </section>

                    <section>
                        <label class="input"> <i class="icon-append fa fa-envelope"></i>
                            {{ Form::email('email', isset($email) ? $email : '', array('placeholder' => '电子邮件地址')) }}
                            <b class="tooltip tooltip-bottom-right">请输入您的电子邮件地址</b> </label>
                    </section>

                    <section>
                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                            {{ Form::password('password', array('placeholder' => '密码')) }}
                            <b class="tooltip tooltip-bottom-right">请输入您的密码，限制为6~64个字符</b> </label>
                    </section>

                    <section>
                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                            {{ Form::password('confirm_password', array('placeholder' => '确认密码')) }}
                            <b class="tooltip tooltip-bottom-right">请重复您刚才输入的密码</b> </label>
                    </section>
                    <section>
                        <label class="checkbox">
                            @if (isset($agree) && $agree === 'on')
                                {{ Form::checkbox('agree', 'on', true, array('id' => 'agree')) }}
                            @else
                                {{ Form::checkbox('agree', 'on', false, array('id' => 'agree')) }}
                            @endif
                            <i></i>我已认真阅读并同意 <a href="#" data-toggle="modal" data-target="#myModal"> 注册许可协议 </a></label>

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
                    <button type="submit" class="btn btn-primary">注册</button>
                </footer>
            {{ Form::close() }}
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">注册协议</h4>
                </div>
                <div class="modal-body custom-scroll terms-body">
                    <div id="left">
                        <h1>许可协议</h1>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="button" class="btn btn-primary" id="i-agree">
                        <i class="fa fa-check"></i> 我同意
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('custom_js')
    <script type="text/javascript">
        runAllForms();

        $("#i-agree").click(function(){
            $this=$("#agree");
            if($this.checked) {
                $('#myModal').modal('toggle');
            } else {
                $this.prop('checked', true);
                $('#myModal').modal('toggle');
            }
        });
    </script>
@stop
