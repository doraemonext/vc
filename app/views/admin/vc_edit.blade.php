@extends('admin.templates.base')

@section('breadcrumb')
<li>投资方管理</li>
<li>添加投资方</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 投资方管理 <span>&gt; 添加投资方 </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a data-toggle="modal" href="{{ route('admin.vc') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回投资方列表</a>
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
                        <h2>添加投资方</h2>
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
                            {{ Form::open(array('action' => 'AdminVcController@submitNew', 'class' => 'form-horizontal', 'files' => 'true')) }}
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">投资方名称</label>
                                        <div class="col-md-9">
                                            {{ Form::text('name', isset($name) ? $name : '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">公司Logo</label>
                                        <div class="col-md-9">
                                            {{ Form::file('logo', array('class' => 'btn btn-default')) }}
                                            <p class="help-block">支持格式：jpg, gif, png，大小 2MB 以内</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">投资领域</label>
                                        <div class="col-md-9">
                                            {{ Form::text('invest_field', isset($invest_field) ? $invest_field : '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">投资规模</label>
                                        <div class="col-md-9">
                                            {{ Form::text('invest_scale', isset($invest_scale) ? $invest_scale : '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">网站</label>
                                        <div class="col-md-9">
                                            {{ Form::text('website', isset($website) ? $website : '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>详细信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">简介摘要</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('summary', isset($summary) ? $summary : '', array('class' => 'form-control', 'rows' => '6')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">简介</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('ckeditor', isset($ckeditor) ? $ckeditor : '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-save"></i>
                                                添加
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
<script src="{{ asset('smartadmin/js/plugin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    pageSetUp();
    CKEDITOR.replace( 'ckeditor', { height: '380px', startupFocus : true} );
});
</script>
@stop