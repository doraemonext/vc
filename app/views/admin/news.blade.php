@extends('admin.templates.base')

@section('breadcrumb')
<li>其他管理</li>
<li>新闻列表</li>
@stop

@section('content')
<?php echo URL::current(); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 新闻列表 </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
	    <a data-toggle="modal" href="{{ route('admin.news.new') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 添加新闻</a>
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
                        <h2>新闻列表</h2>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>

                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <div class="alert alert-info no-margin fade in">
                                <form class="form-inline" role="form">
                                    <fieldset>
                                        <div class="form-group">
                                            {{ Form::text('search', $input['search'], array('class' => 'form-control input-sm', 'placeholder' => '输入您要搜索的内容')); }}
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">应用</button>
                                    </fieldset>
                                </form>
                            </div>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">新闻标题</th>
                                        <th class="col-md-6">内容摘要</th>
                                        <th class="col-md-1">发表时间</th>
                                        <th class="col-md-2">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($news as $new)
                                    <tr>
                                        <td>{{ $new->title }}</td>
                                        <td>{{ nl2br($new->summary) }}</td>
                                        <td>{{ $new->datetime }}</td>
                                        <td>
                                                <button type="button" class="btn btn-info btn-xs">查看</button>
                                                <a href="{{ route('admin.news.edit', $new->id) }}" class="btn btn-success btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs ajax-delete" data-id="{{ $new->id }}">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        {{ $news->appends(array('search' => $input['search']))->links() }}
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
                        url: "{{ route('admin.news.ajax.delete') }}/" + id,
                        dataType: "json",
                        async: "true",
                        success: function(data, textStatus){
                            location.reload();
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