@extends('admin.templates.base')

@section('breadcrumb')
<li>投资方管理</li>
<li>投资方列表</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 投资方管理 <span>&gt; 投资方列表 </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
	    <a data-toggle="modal" href="{{ route('admin.vc.new') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 添加新投资方</a>
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
                        <h2>投资方列表</h2>
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
                                            {{ Form::select('order_by', array('datetime' => '按添加时间排序', 'rating' => '按综合评分排序'), $input['order_by'] === 'datetime' ? $input['order_by'] : 'rating', array('class' => 'form-control input-sm')); }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::select('order', array('positive' => '顺序', 'negative' => '逆序'), $input['order'] === 'negative' ? $input['order'] : 'positive', array('class' => 'form-control input-sm')); }}
                                        </div>
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
                                        <th class="col-md-1">ID</th>
                                        <th class="col-md-1">名称</th>
                                        <th class="col-md-2">投资领域</th>
                                        <th class="col-md-2">投资规模</th>
                                        <th class="col-md-2">网站</th>
                                        <th class="col-md-2">评分</th>
                                        <th class="col-md-2">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vcs as $vc)
                                    <tr>
                                        <td>{{ $vc->id }}</td>
                                        <td>{{ $vc->name }}</td>
                                        <td>{{ $vc->invest_field }}</td>
                                        <td>{{ $vc->invest_scale }}</td>
                                        <td><a href="{{ $vc->website }}">{{ $vc->website }}</a></td>
                                        <td>总评分：{{ $vc->rating }}  （<a href="javascript:void(0);" rel="popover-hover" data-placement="right" data-original-title="{{ $vc->name }}" data-content="<p>总评分：{{ $vc->rating }}</p><p>评分第一项：3.2</p>" data-html="true">查看详细</a>）</td>
                                        <td>
                                                <button type="button" class="btn btn-info btn-xs">查看</button>
                                                <a href="{{ route('admin.vc.edit', $vc->id) }}" class="btn btn-success btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs ajax-delete" data-id="{{ $vc->id }}">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        {{ $vcs->appends(array('search' => $input['search'], 'order_by' => $input['order_by'], 'order' => $input['order']))->links() }}
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
                        url: "{{ route('admin.vc.ajax.delete') }}/" + id,
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