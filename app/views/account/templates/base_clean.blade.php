<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
        <title>{{ $setting['title'] }}@section('page_title')
        @show</title>
        <meta name="description" content="{{ $setting['description'] }}">
        <meta name="HandheldFriendly" content="True">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-production.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-skins.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smartadmin/css/smartadmin-rtl.css') }}">

        <link rel="shortcut icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('smartadmin/img/favicon/favicon.ico') }}" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    </head>
    <body id="login" class="animated fadeInDown">
        <header id="header">
            @section('header')
            <div id="logo-group">
                <span id="logo"> <img src="{{ asset('smartadmin/img/logo.png') }}" alt="SmartAdmin"> </span>
            </div>
            @show
        </header>

        <div id="main" role="main">
            <!-- MAIN CONTENT -->
            <div id="content" class="container">
                <div class="row">
                    @section('content')

                    @show
                </div>
            </div>
        </div>

        <script src="{{ asset('smartadmin/js/plugin/pace/pace.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/libs/jquery-2.0.2.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/libs/jquery-ui-1.10.3.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script> -->
        <script src="{{ asset('smartadmin/js/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/notification/SmartNotification.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/smartwidgets/jarvis.widget.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/select2/select2.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>
        <script src="{{ asset('smartadmin/js/plugin/fastclick/fastclick.js') }}"></script>
        <!--[if IE 7]>
        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
        <![endif]-->
        <!-- MAIN APP JS FILE -->
        <script src="{{ asset('smartadmin/js/app.js') }}"></script>
        @section('custom_js')

        @show
    </body>
</html>