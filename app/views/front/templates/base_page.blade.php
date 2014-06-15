<!DOCTYPE html>
<html>
    <head>
        <title>{{ $setting['title'] }}@section('page_title')
        @show</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="shortcut icon" href="favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <link rel="stylesheet" type="text/css" href="{{ asset('front/css/base.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('front/css/master.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('front/css/column.css') }}">
        <script type="text/javascript" src="{{ asset('front/js/jquery-1.11.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('front/js/master.js') }}"></script>
        <script type="text/javascript" src="{{ asset('front/js/noty/packaged/jquery.noty.packaged.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('front/js/noty/tools.js') }}"></script>
        <!-- 以上是通用的，下面是index才有的 -->
        @section('custom_css')
        @show
    </head>
    <body>
        <div id="popbox" style="display:none">
            <div class="popbox_box login_box" style="display:none">
                <form action="" method="">
                    <div class="box_head">
                        <span class="login_title">登陆</span>
                        <a class="regist_link right" href="">注册账号 >></a>
                    </div>
                    <div class="login_username">
                        <div class="login_head">用户名:</div>
                        <input type="text" id="login_username">
                    </div>
                    <div class="login_password">
                        <div class="login_head">密码：</div>
                        <input type="password" id="login_password">
                        <a class="login_forgotpassword right" href="{{ route('forgotten') }}">忘记密码？</a>
                    </div>
                    <div class="popbox_bottom">
                        <button class="login_blank" id="login_submit">登录</button>
                        <div class="login_remember">
                            <label>
                                <input type="checkbox" id="login_remember">
                                下次自动登录
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="popbox_box regist_box" style="display:none">
                <form action="" method="">
                    <div class="box_head">
                        <span class="regist_title">注册</span>
                        <a class="login_link right" href="">登录 >></a>
                    </div>
                    <div class="regist_username">
                        <div class="regist_head">用户名:</div>
                        <input type="text" id="reg_username">
                    </div>
                    <div class="regist_username">
                        <div class="regist_head">邮箱:</div>
                        <input type="text" id="reg_email">
                    </div>
                    <div class="regist_password">
                        <div class="login_head">密码：</div>
                        <input type="password" id="reg_password">
                    </div>
                    <div class="regist_password">
                        <div class="regist_head">确认密码：</div>
                        <input type="password" id="reg_confirm_password">
                    </div>
                    <div class="popbox_bottom">
                        <button class="regist_blank" id="reg_submit">注册</button>
                    </div>
                </form>
            </div>
            <div class="popbox_bg"></div>
        </div>

        @section('header')
        <div id="header">
            <div class="wrapper">
                <a href="{{ route('home') }}" class="logo"></a>
                <ul id="nav">
                    <li><a href="{{ route('home') }}">首 页</a></li>
                    <li><a href="{{ route('news.list') }}">轶 闻</a></li>
                    <li><a href="{{ route('showcase.list') }}">项 目</a></li>
                    <li><a href="{{ route('vc.list') }}">V C</a></li>
                    <li><a href="{{ route('discuss.list') }}">讨 论</a></li>
                    <li><a href="{{ route('business') }}">商业合作</a></li>
                </ul>
                <div class="search">
                    <form action="{{ route('search') }}" method="get">
                        <input class="search_input" name="q" type="text" value="<?php if(isset($q)) echo $q; ?>">
                        <span class="icon icon_search"></span>
                    </form>
                </div>
                @if (isset($user) && Sentry::getUser()->inGroup(Sentry::findGroupByName('admin')))
                <a class="user right" href="{{ route('admin.home') }}">
                    <span class="user_name">{{ $user->username }}</span>
                    <img class="user_photo" src="{{ Gravatar::src($user->email, 36) }}">
                </a>
                @elseif (isset($user))
                <a class="user right" href="{{ route('user.home') }}">
                    <span class="user_name">{{ $user->username }}</span>
                    <img class="user_photo" src="{{ Gravatar::src($user->email, 36) }}">
                </a>
                @endif

                @if (!isset($user))
                <a class="login" href="{{ route('login') }}">登陆</a>
                @endif
            </div>
        </div>
        @show
        @section('slider')
        @show
        <div id="main">
            @section('leftbar')
            @show
            @section('rightbar')
            @show
            <div class="clear"></div>
        </div>
        @section('footer')
        <div id="footer">
            <div class="wrapper">
                <div class="column_footer">
                    <h3>KingCarat</h3>
                    <ul>
                        <li><a href="{{ route('business.page', 'about') }}">关于我们</a></li>
                        <li><a href="{{ route('business.page', 'ad') }}">联系我们</a></li>
                    </ul>
                </div>
                <div class="column_footer">
                    <h3>合作伙伴</h3>
                    <ul>
                        <li><a href="http://www.sequoiacap.cn/">红杉资本</a></li>
                        <li><a href="http://www.idg.com.cn/">idg</a></li>
                        <li><a href="http://www.ybc.org.cn/">ybc青年创业投资基金</a></li>
                    </ul>
                </div>
                <div class="column_footer">
                    <p>本站由 WebLuker 提供 CDN 加速服务开发协作工具由 Fengche.co 提供</p>
                    <p>Powered By Ruby China</p>
                    <p>©2011-2014 36氪</p>
                    <p>京ICP备11027501号</p>
                    <p>京公网安备11010802012285号</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        @show

        @section('custom_js')
        @show

        <script type="text/javascript">
        $(document).ready(function() {
            $("#login_submit").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('login.ajax') }}",
                    data: {
                        username: $("#login_username").val(),
                        password: $("#login_password").val(),
                        remember: ($("#login_remember").prop('checked')==true)?'on':'',
                    },
                    dataType: "json",
                    cache: false,
                    success: function(data, textStatus) {
                        if (data['code'] != 0) {
                            content = '';
                            for (index = 0; index < data['message'].length; ++index) {
                                content += data['message'][index];
                            }
                            msg(content, 'error');
                        } else {
                            location.reload();
                        }
                    }, error: function(data) {
                        msg('网络错误，请刷新页面后重试', 'error');
                    }
                });
                return false;
            });

            $("#reg_submit").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('register.ajax') }}",
                    data: {
                        username: $("#reg_username").val(),
                        email: $("#reg_email").val(),
                        password: $("#reg_password").val(),
                        confirm_password: $("#reg_confirm_password").val(),
                        agree: 'on',
                    },
                    dataType: "json",
                    cache: false,
                    success: function(data, textStatus) {
                        if (data['code'] != 0) {
                            content = '';
                            for (index = 0; index < data['message'].length; ++index) {
                                content += data['message'][index];
                            }
                            msg(content, 'error');
                        } else {
                            location.reload();
                        }
                    }, error: function(data) {
                        msg('网络错误，请刷新页面后重试', 'error');
                    }
                });
                return false;
            });
        });
        </script>
    </body>
</html>
