@extends('admin.templates.base')

@section('page_title')
-其他管理-<?php if(isset($ad)) echo '编辑广告'; else echo '添加广告'; ?>
@stop

@section('breadcrumb')
<li>其他管理</li>
@if (isset($ad))
<li>编辑广告</li>
@else
<li>添加广告</li>
@endif
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            @if (isset($ad))
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 编辑广告 </span></h1>
            @else
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 添加广告 </span></h1>
            @endif
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a data-toggle="modal" href="{{ route('admin.ad') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回广告列表</a>
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

                @if ($errors->count() > 0)
                <div class="alert alert-danger fade in">
                    @foreach ($errors->all('<li>:message</li>') as $message)
                    {{ $message }}
                    @endforeach
                </div>
                @endif

                @if (Session::has('error'))
                <div class="alert alert-danger fade in">
                    <li>{{ Session::get('error') }}</li>
                </div>
                @endif

                <!-- Widget ID (each widget will need unique ID)-->

                <!-- end widget -->

                <!-- Widget ID (each widget will need unique ID)-->

                <!-- end widget -->

                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        @if (isset($ad))
                        <h2>编辑广告</h2>
                        @else
                        <h2>添加广告</h2>
                        @endif
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>

                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            @if (isset($ad))
                            {{ Form::open(array('action' => array('AdminAdController@submitEdit', $ad->id), 'class' => 'form-horizontal', 'files' => 'true')) }}
                            @else
                            {{ Form::open(array('action' => 'AdminAdController@submitNew', 'class' => 'form-horizontal', 'files' => 'true')) }}
                            @endif
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">广告链接</label>
                                        <div class="col-md-9">
                                            @if (isset($ad))
                                            {{ Form::text('url', $ad->url, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('url', isset($url) ? $url : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">广告图片</label>
                                        <div class="col-md-9">
                                            {{ Form::file('picture', array('class' => 'btn btn-default')) }}
                                            @if (isset($ad))
                                            <p class="help-block">如果您需要更新图片，请直接上传即可覆盖。如果不需要更新图片，请保持为空</p>
                                            @endif
                                            <p class="help-block">支持格式：jpg, gif, png，大小 2MB 以内</p>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-save"></i>
                                                @if (isset($ad))
                                                编辑
                                                @else
                                                添加
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            {{ Form::close() }}
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