@extends('admin.templates.base')

@section('page_title')
@if ($type == 'vc')
-投资方管理-编辑回复
@elseif ($type == 'showcase')
-项目管理-编辑回复
@elseif ($type == 'news')
-其他管理-编辑回复
@endif
@stop

@section('breadcrumb')
@if ($type == 'vc')
<li>投资方管理</li>
@elseif ($type == 'showcase')
<li>项目管理</li>
@elseif ($type == 'news')
<li>其他管理</li>
@endif
<li>编辑回复</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i>
                @if ($type == 'vc')
                投资方管理 <span>&gt;
                @elseif ($type == 'showcase')
                项目管理 <span>&gt;
                @elseif ($type == 'news')
                其他管理 <span>&gt;
                @endif
                编辑回复
            </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            @if ($type == 'vc')
            <a data-toggle="modal" href="{{ route('admin.vc.comment') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回我的回复列表</a>
            @elseif ($type == 'showcase')
            <a data-toggle="modal" href="{{ route('admin.showcase.comment') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回我的回复列表</a>
            @elseif ($type == 'news')
            <a data-toggle="modal" href="{{ route('admin.news.comment') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回我的回复列表</a>
            @endif
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
                        <h2>编辑回复</h2>
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
                            @if ($type == 'vc')
                            {{ Form::open(array('action' => array('AdminVcController@submitCommentEdit', $comment->id), 'class' => 'form-horizontal')) }}
                            @elseif ($type == 'showcase')
                            {{ Form::open(array('action' => array('AdminShowcaseController@submitCommentEdit', $comment->id), 'class' => 'form-horizontal')) }}
                            @elseif ($type == 'news')
                            {{ Form::open(array('action' => array('AdminNewsController@submitCommentEdit', $comment->id), 'class' => 'form-horizontal')) }}
                            @endif
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">话题名称</label>
                                        <div class="col-md-9">
                                            @if ($type == 'vc')
                                            <input class="form-control" disabled="disabled" placeholder="{{ $comment->vc->name }}" type="text">
                                            @elseif ($type == 'showcase')
                                            <input class="form-control" disabled="disabled" placeholder="{{ $comment->showcase->name }}" type="text">
                                            @elseif ($type == 'news')
                                            <input class="form-control" disabled="disabled" placeholder="{{ $comment->news->title }}" type="text">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">回复内容</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('content', $comment->content, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-save"></i>
                                                编辑
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