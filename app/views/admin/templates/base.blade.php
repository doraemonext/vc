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
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-production.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-skins.css') }}">
        @section('custom_css')
        @show

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">
    </head>
    <body class="">
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
                        <img src="{{ asset('smartadmin/img/avatars/sunny.png') }}" alt="me" class="online" />
                        <span>{{ $user->username }}</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </span>
            </div>
            <!-- end user info -->

            <nav>
                <ul>
                    <li>
                        <a href="{{ route('admin.home') }}" title="系统概览"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">系统概览</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i> <span class="menu-item-parent">投资方管理</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.vc') }}">投资方列表</a>
                            </li>
                            <li>
                                <a href="">投资方评论管理</a>
                            </li>
                            <li>
                                <a href="">评分分类管理</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">项目管理</span></a>
                        <ul>
                            <li>
                                <a href="">项目列表</a>
                            </li>
                            <li>
                                <a href="">分类管理</a>
                            </li>
                            <li>
                                <a href="">项目评论管理</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-lg fa-fw fa-windows"></i> <span class="menu-item-parent">其他管理</span></a>
                        <ul>
                            <li>
                                <a href="">新闻列表</a>
                            </li>
                            <li>
                                <a href="">新闻评论管理</a>
                            </li>
                            <li>
                                <a href="">会员管理</a>
                            </li>
                            <li>
                                <a href="">广告管理</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-lg fa-fw fa-cog"></i> <span class="menu-item-parent">系统设置</span></a>
                        <ul>
                            <li>
                                <a href="">系统设置</a>
                            </li>
                        </ul>
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
        </script>

    </body>

</html>