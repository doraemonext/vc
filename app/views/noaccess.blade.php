
<!DOCTYPE html>
<html lang="en-us">
    <head>
	<meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
	<title> {{ $setting['title'] }} - 禁止访问 </title>
	<meta name="description" content="{{ $setting['description'] }}">

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<!-- Basic Styles -->
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/font-awesome.min.css') }}">

	<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-production.css') }}">
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-skins.css') }}">

	<!-- SmartAdmin RTL Support is under construction
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-rtl.css') }}"> -->

	<!-- page related CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/lockscreen.css') }}">

	<!-- FAVICONS -->
	<link rel="shortcut icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">
    </head>
    <body>

	<div id="main" role="main">

	    <!-- MAIN CONTENT -->

	    <div class="lockscreen animated flipInY">
		<div class="logo">
		    <h1 class="semi-bold"><img src="{{ asset('smartadmin/img/logo-o.png') }}" alt="" /> {{ $setting['title'] }}</h1>
		</div>
		<div>
		    <div>
			<h1><i class="fa fa-user fa-3x text-muted air air-top-right hidden-mobile"></i>对不起 <small><i class="fa fa-lock text-muted"></i> &nbsp;{{ $error or '您没有访问该页面的权限' }}</small></h1>
			<p class="text-muted">
                            如果您需要提升权限，请联系管理员解决
			</p>
		    </div>

		</div>
	    </div>

	</div>

	<!--================================================== -->

	<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)
	<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('smartadmin/js/plugin/pace/pace.min.js') }}"></script>-->

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

    </body>
</html>