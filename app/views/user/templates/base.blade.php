<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> SmartAdmin </title>
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/font-awesome.min.css') }}">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-production_unminified.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-skins.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/custom.css') }}">
        @section('custom_css')
        @show

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">
    </head>
    <body class="smart-style-0">
        <!-- HEADER -->
        <header id="header">
            <div id="logo-group">
                <span id="logo"> <img src="{{ asset('smartadmin/img/logo.png') }}" alt="SmartAdmin"> </span>
            </div>

            <!-- pulled right: nav area -->
            <div class="pull-right">
                <!-- collapse menu button -->
                <div id="hide-menu" class="btn-header pull-right">
                    <span> <a href="javascript:void(0);" title="显示/隐藏菜单"><i class="fa fa-reorder"></i></a> </span>
                </div>
                <!-- end collapse menu -->

                <!-- logout button -->
                <div id="logout" class="btn-header transparent pull-right">
                    <span> <a href="{{ route('logout') }}" title="登出"><i class="fa fa-sign-out"></i></a> </span>
                </div>
                <!-- end logout button -->
            </div>
            <!-- end pulled right: nav area -->
        </header>
        <!-- END HEADER -->

        <!-- Left panel : Navigation area -->
        <!-- Note: This width of the aside area can be adjusted through LESS variables -->
        <aside id="left-panel">
            <!-- User info -->
            <div class="login-info">
                <span> <!-- User image size is adjusted inside CSS, it should stay as it -->
                    <a href="javascript:void(0);" id="show-shortcut">
                        <img src="{{ Gravatar::src($user->email, 50) }}" alt="me" class="online" />
                        <span>{{ $user->username }}</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </span>
            </div>
            <!-- end user info -->

            <nav>
                <ul>
                    <li <?php if($action_name[0]==='UserHomeController') echo 'class="active"'; ?>>
                        <a href="{{ route('user.home') }}" title="个人中心"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">个人中心</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i> <span class="menu-item-parent">我的项目</span></a>
                        <ul>
                            <li <?php if($action_name[0]==='UserShowcaseController'&&($action_name[1]==='showShowcase'||$action_name[1]==='showEdit')) echo 'class="active"'; ?>>
                                <a href="{{ route('user.showcase') }}">已发布的项目</a>
                            </li>
                            <li <?php if($action_name[0]==='UserShowcaseController'&&$action_name[1]==='showNew') echo 'class="active"'; ?>>
                                <a href="{{ route('user.showcase.new') }}">新建项目</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">我的评价</span></a>
                        <ul>
                            <li <?php if($action_name[0]==='UserEvaluateController'&&$action_name[1]==='showRating') echo 'class="active"'; ?>>
                                <a href="{{ route('user.evaluate.rating') }}">我的评分列表</a>
                            </li>
                            <li <?php if($action_name[0]==='UserEvaluateController'&&$action_name[1]==='showComment') echo 'class="active"'; ?>>
                                <a href="{{ route('user.evaluate.comment') }}">我的评论列表</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-lg fa-fw fa-windows"></i> <span class="menu-item-parent">我的讨论区</span></a>
                        <ul>
                            <li>
                                <a href="">我的主题</a>
                            </li>
                            <li>
                                <a href="">我的回复</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($action_name[0]==='UserSettingController') echo 'class="active"'; ?>>
                        <a href="{{ route('user.setting') }}" title="个人设置"><i class="fa fa-lg fa-fw fa-cogs"></i> <span class="menu-item-parent">个人设置</span></a>
                    </li>                    
                </ul>
            </nav>
            <span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i> </span>

        </aside>
        <!-- END NAVIGATION -->

        <!-- MAIN PANEL -->
        <div id="main" role="main">

            <!-- RIBBON -->
            <div id="ribbon">
                <span class="ribbon-button-alignment"> <span id="refresh" class="btn btn-ribbon" data-title="refresh" rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> 警告！这将会清除所有的本地缓存" data-html="true"><i class="fa fa-refresh"></i></span> </span>
                <!-- breadcrumb -->
                <ol class="breadcrumb">
                    <i class="fa fa-lg fa-fw fa-home"></i>
                    @section('breadcrumb')
                    @show
                </ol>
                <!-- end breadcrumb -->
            </div>
            <!-- END RIBBON -->

            <!-- MAIN CONTENT -->
            @section('content')
            @show
            <!-- END MAIN CONTENT -->

        </div>
        <!-- END MAIN PANEL -->

        <!--================================================== -->

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('smartadmin/js/plugin/pace/pace.min.js') }}"></script>

	<script src="{{ asset('smartadmin/js/libs/jquery-2.0.2.min.js') }}"></script>
	<script src="{{ asset('smartadmin/js/libs/jquery-ui-1.10.3.min.js') }}"></script>

	<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
	<script src="{{ asset('smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script> -->

	<!-- BOOTSTRAP JS -->
	<script src="{{ asset('smartadmin/js/bootstrap/bootstrap.min.js') }}"></script>

	<!-- CUSTOM NOTIFICATION -->
	<script src="{{ asset('smartadmin/js/notification/SmartNotification.min.js') }}"></script>

	<!-- JARVIS WIDGETS -->
	<script src="{{ asset('smartadmin/js/smartwidgets/jarvis.widget.min.js') }}"></script>

	<!-- EASY PIE CHARTS -->
	<script src="{{ asset('smartadmin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

	<!-- SPARKLINES -->
	<script src="{{ asset('smartadmin/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

	<!-- JQUERY VALIDATE -->
	<script src="{{ asset('smartadmin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

	<!-- JQUERY MASKED INPUT -->
	<script src="{{ asset('smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

	<!-- JQUERY SELECT2 INPUT -->
	<script src="{{ asset('smartadmin/js/plugin/select2/select2.min.js') }}"></script>

	<!-- JQUERY UI + Bootstrap Slider -->
	<script src="{{ asset('smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>

	<!-- browser msie issue fix -->
	<script src="{{ asset('smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

	<!-- FastClick: For mobile devices -->
	<script src="{{ asset('smartadmin/js/plugin/fastclick/fastclick.js') }}"></script>

	<!--[if IE 7]>
	<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
	<![endif]-->

	<!-- MAIN APP JS FILE -->
	<script src="{{ asset('smartadmin/js/app.js') }}"></script>

    @section('custom_js')
	<script type="text/javascript">

	// DO NOT REMOVE : GLOBAL FUNCTIONS!

	$(document).ready(function() {
	    pageSetUp();
	})

	</script>
    @show
    </body>
</html>