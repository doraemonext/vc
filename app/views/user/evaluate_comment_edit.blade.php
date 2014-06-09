@extends('user.templates.base')

@section('breadcrumb')
<li>我的评价</li>
<li>我的评论列表</li>
<li>编辑评论</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 我的评价 <span>&gt; 编辑评论 </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a data-toggle="modal" href="{{ route('user.evaluate.comment.vc') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回我的评论列表</a>
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
                        <h2>编辑评论</h2>
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
                            {{ Form::open(array('action' => array('UserEvaluateController@submitCommentVc', $comment->id), 'class' => 'form-horizontal')) }}
                            @elseif ($type == 'showcase')
                            {{ Form::open(array('action' => array('UserEvaluateController@submitCommentShowcase', $comment->id), 'class' => 'form-horizontal')) }}
                            @elseif ($type == 'news')
                            {{ Form::open(array('action' => array('UserEvaluateController@submitCommentNews', $comment->id), 'class' => 'form-horizontal')) }}
                            @endif
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">评论对象</label>
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
                                        <label class="col-md-2 control-label">评论内容</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('content', $comment->content, array('class' => 'form-control', 'rows' => '6')) }}
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