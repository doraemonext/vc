@extends('user.templates.base')

@section('page_title')
@stop

@section('breadcrumb')
<li>个人中心</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-home fa-fw "></i> 个人中心 </h1>
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">项目名称</th>
                                        <th class="col-md-1">公司名称</th>
                                        <th class="col-md-1">联系方式(邮箱)</th>
                                        <th class="col-md-1">项目领域</th>
                                        <th class="col-md-1">支持数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showcases as $showcase)
                                    <tr>
                                        <td><a href="{{ route('showcase.item', $showcase->id) }}">{{ $showcase->name }}</a></td>
                                        <td>{{ $showcase->company }}</td>
                                        <td>{{ $showcase->contact_email }}</td>
                                        <td>{{ $showcase->category->title }}</td>
                                        <td>{{ $showcase->vote }}</td>
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
                        <h2>我的评论（投资方）</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.evaluate.comment.vc') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                           <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">评论对象</th>
                                        <th class="col-md-2">我的评论</th>
                                        <th class="col-md-1">评论时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments_vc as $comment)
                                    <tr>
                                        <td><a href="{{ route('vc.item', $comment->vc->id) }}">{{ $comment->vc->name }}</a></td>
                                        <td>{{ nl2br($comment->content) }}</td>
                                        <td>{{ $comment->datetime }}</td>
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
                        <h2>我的评论（项目）</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.evaluate.comment.showcase') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                           <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">评论对象</th>
                                        <th class="col-md-2">我的评论</th>
                                        <th class="col-md-1">评论时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments_showcase as $comment)
                                    <tr>
                                        <td><a href="{{ route('showcase.item', $comment->showcase->id) }}">{{ $comment->showcase->name }}</a></td>
                                        <td>{{ nl2br($comment->content) }}</td>
                                        <td>{{ $comment->datetime }}</td>
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
                        <h2>我的评论（新闻）</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.evaluate.comment.news') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                           <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">评论对象</th>
                                        <th class="col-md-2">我的评论</th>
                                        <th class="col-md-1">评论时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments_news as $comment)
                                    <tr>
                                        <td><a href="{{ route('news.item', $comment->news->id) }}">{{ $comment->news->title }}</a></td>
                                        <td>{{ nl2br($comment->content) }}</td>
                                        <td>{{ $comment->datetime }}</td>
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
                        <span class="widget-icon"> <i class="fa fa-windows"></i> </span>
                        <h2>我的讨论区话题</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.discuss.topic') }}" class="btn btn-success">查看全部...</a>
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
                                        <th class="col-md-2">发布时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discusses as $discuss)
                                    <tr>
                                        <td><a href="{{ route('discuss.item', $discuss->id) }}">{{ $discuss->title }}</a></td>
                                        <td>{{ $discuss->vote }}</td>
                                        <td>{{ $discuss->comment_count }}</td>
                                        <td>{{ $discuss->datetime }}</td>
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
                        <span class="widget-icon"> <i class="fa fa-windows"></i> </span>
                        <h2>我的讨论区回复</h2>

                        <div class="widget-toolbar" role="menu">
                            <a href="{{ route('user.discuss.comment') }}" class="btn btn-success">查看全部...</a>
                        </div>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>
                    <div class="no-padding" role="content">
                        <div class="widget-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">话题</th>
                                        <th class="col-md-6">我的回复</th>
                                        <th class="col-md-2">发布时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discuss_comments as $comment)
                                    <tr>
                                        <td><a href="{{ route('discuss.item', $comment->discuss->id) }}">{{ $comment->discuss->title }}</a></td>
                                        <td>{{ $comment->content }}</td>
                                        <td>{{ $comment->datetime }}</td>
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

@section('custom_js')
<script type="text/javascript">
$(document).ready(function() {
    pageSetUp();
});
</script>
@stop
