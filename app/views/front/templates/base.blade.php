<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
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
        @section('header')
        <div id="header">
            <div class="wrapper">
                <a href="{{ route('home') }}" class="logo"></a>
                <ul id="nav">
                    <li><a href="{{ route('home') }}">首页</a></li>
                    <li><a href="{{ route('showcase.list') }}">项目展示</a></li>
                    <li><a href="{{ route('vc.list') }}">VC展示</a></li>
                    <li><a href="{{ route('discuss.list') }}">讨论区</a></li>
                    <li id="drop">
                        <a href="">商业合作</a>
                        <ul class="dropdown">
                            <li><a href="">文章投稿</a></li>
                            <li><a href="">寻求报道</a></li>
                            <li><a href="">广告合作</a></li>
                            <li><a href="">联系我们</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="search">
                    <form action="/search" method="get">
                        <input class="search_input" name="q" type="text">
                        <span class="icon icon_search"></span>
                    </form>
                </div>
                @if (isset($user))
                <a class="user right" href="{{ route('user.home') }}">
                    <span class="user_name">{{ $user->username }}</span>
                    <img class="user_photo" src="{{ Gravatar::src($user->email, 36) }}">
                </a>
                @else
                <a class="login" href="{{ route('login') }}">登陆</a>
                @endif
            </div>
        </div>
        @show
        @section('slider')
        @show
        <div id="main">
            <div class="wrapper">
                <div id="content">
                    @section('leftbar')
                    @show
                    @section('mainbar')
                    @show
                </div>
                @section('rightbar')
                @show
            </div>
            @show
            <div class="clear"></div>
        </div>
        @section('footer')
        <div id="footer">
            <div class="wrapper">
                <div class="column_footer">
                    <h3>25K</h3>
                    <ul>
                        <li><a href="">关于我们</a></li>
                        <li><a href="">联系我们</a></li>
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
    </body>
</html>
