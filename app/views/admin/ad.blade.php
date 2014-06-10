@extends('admin.templates.base')

@section('breadcrumb')
<li>其他管理</li>
<li>广告管理</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i>
                其他管理 <span>&gt;
                广告管理
            </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
           <a data-toggle="modal" href="{{ route('admin.ad.new') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 添加新广告</a>
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
                        <h2>广告管理</h2>
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
                                        <th class="col-md-8">广告图片</th>
                                        <th class="col-md-3">链接地址</th>
                                        <th class="col-md-1">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ads as $ad)
                                    <tr>
                                        <td><img class="img-responsive" src="{{ Croppa::url($config_upload['ad.picture'].$ad->picture, 1366, 260) }}"></td>
                                        <td><a href="{{ $ad->url }}">{{ $ad->url }}</a></td>
                                        <td>
                                            <a href="{{ route('admin.ad.edit', $ad->id) }}" class="btn btn-success btn-xs">编辑</a>
                                            <a class="btn btn-danger btn-xs ajax-delete" data-id="{{ $ad->id }}">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        {{ $ads->links() }}
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
                        url: "{{ route('admin.ad.ajax.delete') }}/" + id,
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