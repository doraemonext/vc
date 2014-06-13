@extends('admin.templates.base')

@section('page_title')
@if ($type == 'vc')
-投资方管理-投资方评论管理
@elseif ($type == 'showcase')
-项目管理-项目评论管理
@elseif ($type == 'news')
-其他管理-新闻评论管理
@endif
@stop

@section('breadcrumb')
@if ($type == 'vc')
<li>投资方管理</li>
<li>投资方评论管理</li>
@elseif ($type == 'showcase')
<li>项目管理</li>
<li>项目评论管理</li>
@elseif ($type == 'news')
<li>其他管理</li>
<li>新闻评论管理</li>
@endif
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i>
                @if ($type == 'vc')
                投资方管理 <span>&gt;
                投资方评论管理
                @elseif ($type == 'showcase')
                项目管理 <span>&gt;
                项目评论管理
                @elseif ($type == 'news')
                其他管理 <span>&gt;
                新闻评论管理
                @endif
            </span></h1>
        </div>
    </div>

    <!-- widget grid -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

                @if (Session::has('status'))
                <div class="alert alert-{{ Session::get('status') }} fade in">
                    <button class="close" data-dismiss="alert">×</button>
                    <i class="fa-fw fa fa-info"></i>
                    {{ Session::get('message') }}
                </div>
                @endif

                <!-- Widget ID (each widget will need unique ID)-->

                <!-- end widget -->

                <!-- Widget ID (each widget will need unique ID)-->

                <!-- end widget -->

                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        @if ($type == 'vc')
                        <h2>投资方评论管理</h2>
                        @elseif ($type == 'showcase')
                        <h2>项目评论管理</h2>
                        @elseif ($type == 'news')
                        <h2>新闻评论管理</h2>
                        @endif
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>

                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">评论对象</th>
                                        <th class="col-md-7">评论内容</th>
                                        <th class="col-md-1">评论用户</th>
                                        <th class="col-md-1">评论时间</th>
                                        <th class="col-md-1">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                    <tr>
                                        @if ($type == 'vc')
                                        <td><a href="{{ route('vc.item', $comment->vc->id) }}">{{ $comment->vc->name }}</a></td>
                                        @elseif ($type == 'showcase')
                                        <td><a href="{{ route('showcase.item', $comment->showcase->id) }}">{{ $comment->showcase->name }}</a></td>
                                        @elseif ($type == 'news')
                                        <td><a href="{{ route('news.item', $comment->news->id) }}">{{ $comment->news->title }}</a></td>
                                        @endif

                                        <td>{{ nl2br($comment->content) }}</td>
                                        <td>{{ $comment->user->username }}</td>
                                        <td>{{ $comment->datetime }}</td>
                                        <td>
                                            @if ($type == 'vc')
                                            <a href="{{ route('admin.vc.comment.edit', $comment->id) }}" class="btn btn-success btn-xs">编辑</a>
                                            @elseif ($type == 'showcase')
                                            <a href="{{ route('admin.showcase.comment.edit', $comment->id) }}" class="btn btn-success btn-xs">编辑</a>
                                            @elseif ($type == 'news')
                                            <a href="{{ route('admin.news.comment.edit', $comment->id) }}" class="btn btn-success btn-xs">编辑</a>
                                            @endif

                                            <a class="btn btn-danger btn-xs ajax-delete" data-id="{{ $comment->id }}">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        {{ $comments->links() }}
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

    $(".ajax-delete").click(function(e) {
        var id = $(this).data('id');

        $.SmartMessageBox({
            title : "确认删除",
            content : "您确认要删除该条记录吗？",
            buttons : '[取消][确认]'
        }, function(ButtonPressed) {
                if (ButtonPressed === "确认") {
                    $.ajax({
                        type: "GET",

                        @if ($type == 'vc')
                        url: "{{ route('admin.vc.comment.ajax.delete') }}/" + id,
                        @elseif ($type == 'showcase')
                        url: "{{ route('admin.showcase.comment.ajax.delete') }}/" + id,
                        @elseif ($type == 'news')
                        url: "{{ route('admin.news.comment.ajax.delete') }}/" + id,
                        @endif

                        dataType: "json",
                        async: "true",
                        success: function(data, textStatus){
                            if (data['code'] == 0) {
                                location.reload();
                            } else {
                                $.smallBox({
                                    title : "发生错误",
                                    content : data['message'],
                                    color : "#C46A69",
                                    iconSmall : "fa fa-lock fa-2x fadeInRight animated",
                                    timeout : 4000
                                });
                            }
                        }, error: function(data){
                            $.smallBox({
                                title : "发生错误",
                                content : "在发送请求时出现错误，请刷新页面后重试",
                                color : "#C46A69",
                                iconSmall : "fa fa-lock fa-2x fadeInRight animated",
                                timeout : 4000
                            });
                        }
                    });
                }
                if (ButtonPressed === "取消") {

                }

            });
            e.preventDefault();
        });
    });
</script>
@stop