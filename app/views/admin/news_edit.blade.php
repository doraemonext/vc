@extends('admin.templates.base')

@section('page_title')
@if (isset($news))
-其他管理-编辑新闻
@else
-其他管理-添加新闻
@endif
@stop

@section('breadcrumb')
<li>其他管理</li>
@if (isset($news))
<li>编辑新闻</li>
@else
<li>添加新闻</li>
@endif
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            @if (isset($news))
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 编辑新闻 </span></h1>
            @else
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 添加新闻 </span></h1>
            @endif
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a data-toggle="modal" href="{{ route('admin.news') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回新闻列表</a>
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
                        @if (isset($news))
                        <h2>编辑新闻</h2>
                        @else
                        <h2>添加新闻</h2>
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
                            @if (isset($news))
                            {{ Form::open(array('action' => array('AdminNewsController@submitEdit', $news->id), 'class' => 'form-horizontal', 'files' => 'true')) }}
                            @else
                            {{ Form::open(array('action' => 'AdminNewsController@submitNew', 'class' => 'form-horizontal', 'files' => 'true')) }}
                            @endif
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">新闻名称</label>
                                        <div class="col-md-9">
                                            @if (isset($news))
                                            {{ Form::text('title', $news->title, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('title', isset($title) ? $title : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">新闻配图</label>
                                        <div class="col-md-9">
                                            {{ Form::file('picture', array('class' => 'btn btn-default')) }}
                                            @if (isset($news))
                                            <p class="help-block">如果您需要更新图片，请直接上传即可覆盖；如果不需要，请保持此处为空。</p>
                                            @endif
                                            <p class="help-block">支持格式：jpg, gif, png，大小 2MB 以内</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">新闻分类</label>
                                        <div class="col-md-9">
                                            @if (isset($news))
                                            {{ Form::select('category_id', $category_select, $news->category_id, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::select('category_id', $category_select, 1, array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>详细信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">新闻摘要</label>
                                        <div class="col-md-9">
                                            @if (isset($news))
                                            {{ Form::textarea('summary', $news->summary, array('class' => 'form-control', 'rows' => '6')) }}
                                            @else
                                            {{ Form::textarea('summary', isset($summary) ? $summary : '', array('class' => 'form-control', 'rows' => '6')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">新闻内容</label>
                                        <div class="col-md-9">
                                            @if (isset($news))
                                            {{ Form::textarea('ckeditor', $news->content, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::textarea('ckeditor', isset($ckeditor) ? $ckeditor : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-save"></i>
                                                @if (isset($news))
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
<script src="{{ asset('smartadmin/js/plugin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    pageSetUp();
    CKEDITOR.replace( 'ckeditor', { height: '380px', startupFocus : true} );
});
</script>
@stop