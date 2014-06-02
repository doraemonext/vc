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
	    <a data-toggle="modal" href="#myModal" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 添加新投资方</a>
	</div>
    </div>

    <!-- widget grid -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

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
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-xs">查看</button>
                                                <button type="button" class="btn btn-success btn-xs">编辑</button>
                                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                                            </div>
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