@extends('admin.templates.base')

@section('page_title')
-系统概览
@stop

@section('breadcrumb')
<li>系统概览</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-home fa-fw "></i> 系统概览 </h1>
        </div>
    </div>

    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2>我的项目</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.showcase') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">

                        </div>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>我的评论（投资方）</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.evaluate.comment.vc') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">

                        </div>
                    </div>
                </div>
            </article>
        </div>

        <div class="row">
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>我的评论（项目）</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.evaluate.comment.showcase') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">

                        </div>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>我的评论（新闻）</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.evaluate.comment.news') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">

                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row">
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-windows"></i> </span>
                        <h2>我的讨论区话题</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.discuss.topic') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">

                        </div>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-windows"></i> </span>
                        <h2>我的讨论区回复</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.discuss.comment') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">

                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
@stop
