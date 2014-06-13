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
                        <h2>投资方</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('admin.vc') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">名称</th>
                                        <th class="col-md-2">投资领域</th>
                                        <th class="col-md-2">投资规模</th>
                                        <th class="col-md-2">网站</th>
                                        <th class="col-md-1">是否推荐</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vcs as $vc)
                                    <tr>
                                        <td><a href="{{ route('vc.item', $vc->id) }}">{{ $vc->name }}</a></td>
                                        <td>{{ $vc->invest_field }}</td>
                                        <td>{{ $vc->invest_scale }}</td>
                                        <td><a href="{{ $vc->website }}">{{ $vc->website }}</a></td>
                                        <td>
                                            @if ($vc->recommended)
                                            <span class="label label-success">是</span>
                                            @else
                                            <span class="label label-primary">否</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>项目</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('admin.showcase') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">项目名称</th>
                                        <th class="col-md-1">公司名称</th>
                                        <th class="col-md-1">联系方式(邮箱)</th>
                                        <th class="col-md-1">所属用户</th>
                                        <th class="col-md-1">是否推荐</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showcases as $showcase)
                                    <tr>
                                        <td><a href="{{ route('showcase.item', $showcase->id) }}">{{ $showcase->name }}</a></td>
                                        <td>{{ $showcase->company }}</td>
                                        <td>{{ $showcase->contact_email }}</td>
                                        <td>{{ $showcase->user->username }}</td>
                                        <td>
                                            @if ($showcase->recommended)
                                            <span class="label label-success">是</span>
                                            @else
                                            <span class="label label-primary">否</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        <h2>新闻</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('admin.news') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">新闻标题</th>
                                        <th class="col-md-1">新闻分类</th>
                                        <th class="col-md-3">内容摘要</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($news as $new)
                                    <tr>
                                        <td><a href="{{ route('news.item', $new->id) }}">{{ $new->title }}</a></td>
                                        <td>{{ $new->category->title }}</td>
                                        <td>{{ nl2br($new->summary) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>讨论区主题</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('admin.discuss.topic') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">话题</th>
                                        <th class="col-md-2">点赞数</th>
                                        <th class="col-md-2">评论数</th>
                                        <th class="col-md-2">发布人</th>
                                        <th class="col-md-2">发布时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discusses as $discuss)
                                    <tr>
                                        <td><a href="{{ route('discuss.item', $discuss->id) }}">{{ $discuss->title }}</a></td>
                                        <td>{{ $discuss->vote }}</td>
                                        <td>{{ $discuss->comment_count }}</td>
                                        <td>{{ $discuss->user->username }}</td>
                                        <td>{{ $discuss->datetime }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
@stop
