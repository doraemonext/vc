@extends('admin.templates.base')

@section('breadcrumb')
<li>项目管理</li>
<li>编辑项目</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 项目管理 <span>&gt; 编辑项目 </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a data-toggle="modal" href="{{ route('admin.showcase') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回项目列表</a>
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
                        <h2>编辑项目（该项目所属用户：{{ $user->username }}）</h2>
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
                            {{ Form::open(array('action' => array('AdminShowcaseController@submitEdit', $showcase->id), 'class' => 'form-horizontal', 'files' => 'true')) }}
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">项目名称</label>
                                        <div class="col-md-9">
                                            {{ Form::text('name', $showcase->name, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">项目Logo</label>
                                        <div class="col-md-9">
                                            {{ Form::file('logo', array('class' => 'btn btn-default')) }}
                                            <p class="help-block">如果您需要更新图片，请直接上传即可覆盖；如果不需要，请保持此处为空。</p>
                                            <p class="help-block">支持格式：jpg, gif, png，大小 2MB 以内</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">公司名称</label>
                                        <div class="col-md-9">
                                            {{ Form::text('company', $showcase->company, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">联系人</label>
                                        <div class="col-md-9">
                                            {{ Form::text('contact_person', $showcase->contact_person, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">联系方式(邮箱)</label>
                                        <div class="col-md-9">
                                            {{ Form::text('contact_email', $showcase->contact_email, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">联系方式(电话)</label>
                                        <div class="col-md-9">
                                            {{ Form::text('contact_phone', $showcase->contact_phone, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">项目领域</label>
                                        <div class="col-md-9">
                                            {{ Form::select('category_id', $category_select, $showcase->category_id, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">项目运营时间</label>
                                        <div class="col-md-9">
                                            {{ Form::text('operation_time', $showcase->operation_time, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>详细信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">项目简介</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('summary', $showcase->summary, array('class' => 'form-control', 'rows' => '6')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">详细介绍</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('ckeditor', $showcase->content, array('class' => 'form-control')) }}
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
<script src="{{ asset('smartadmin/js/plugin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    pageSetUp();
    CKEDITOR.replace( 'ckeditor', { height: '380px', startupFocus : true} );
});
</script>
@stop