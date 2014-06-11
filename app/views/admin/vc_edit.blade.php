@extends('admin.templates.base')

@section('breadcrumb')
<li>投资方管理</li>
@if (isset($vc))
<li>编辑投资方</li>
@else
<li>添加投资方</li>
@endif
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            @if (isset($vc))
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 投资方管理 <span>&gt; 编辑投资方 </span></h1>
            @else
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 投资方管理 <span>&gt; 添加投资方 </span></h1>
            @endif
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
                        @if (isset($vc))
                        <h2>编辑投资方</h2>
                        @else
                        <h2>添加投资方</h2>
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
                            @if (isset($vc))
                            {{ Form::open(array('action' => array('AdminVcController@submitEdit', $vc->id), 'class' => 'form-horizontal', 'files' => 'true')) }}
                            @else
                            {{ Form::open(array('action' => 'AdminVcController@submitNew', 'class' => 'form-horizontal', 'files' => 'true')) }}
                            @endif
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">投资方名称</label>
                                        <div class="col-md-9">
                                            @if (isset($vc))
                                            {{ Form::text('name', $vc->name, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('name', isset($name) ? $name : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label"><strong>是否推荐</strong></label>
                                        <div class="col-md-9">
                                            @if (isset($vc))
                                            {{ Form::select('recommended', array(1 => '是', 0 => '否'), $vc->recommended, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::select('recommended', array(1 => '是', 0 => '否'), 0, array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">公司Logo</label>
                                        <div class="col-md-9">
                                            {{ Form::file('logo', array('class' => 'btn btn-default')) }}
                                            @if (isset($vc))
                                            <p class="help-block">如果您需要更新图片，请直接上传即可覆盖；如果不需要，请保持此处为空。</p>
                                            @endif
                                            <p class="help-block">支持格式：jpg, gif, png，大小 2MB 以内</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">投资领域</label>
                                        <div class="col-md-9">
                                            @if (isset($vc))
                                            {{ Form::text('invest_field', $vc->invest_field, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('invest_field', isset($invest_field) ? $invest_field : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">投资规模</label>
                                        <div class="col-md-9">
                                            @if (isset($vc))
                                            {{ Form::text('invest_scale', $vc->invest_scale, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('invest_scale', isset($invest_scale) ? $invest_scale : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">网站</label>
                                        <div class="col-md-9">
                                            @if (isset($vc))
                                            {{ Form::text('website', $vc->website, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('website', isset($website) ? $website : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>详细信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">简介摘要</label>
                                        <div class="col-md-9">
                                            @if (isset($vc))
                                            {{ Form::textarea('summary', $vc->summary, array('class' => 'form-control', 'rows' => '6')) }}
                                            @else
                                            {{ Form::textarea('summary', isset($summary) ? $summary : '', array('class' => 'form-control', 'rows' => '6')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">简介</label>
                                        <div class="col-md-9">
                                            @if (isset($vc))
                                            {{ Form::textarea('ckeditor', $vc->content, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::textarea('ckeditor', isset($ckeditor) ? $ckeditor : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    @if (isset($vc))
                                    @foreach ($vc->showcases as $index => $s)
                                    <legend>投资案例 {{ $index + 1 }}</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">案例名称</label>
                                        <div class="col-md-9">
                                            {{ Form::text('showcase_'.strval($index+1).'_title', $s->title, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">案例内容</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('showcase_'.strval($index+1).'_content', $s->content, array('class' => 'form-control', 'rows' => '6')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">跳转链接</label>
                                        <div class="col-md-9">
                                            {{ Form::text('showcase_'.strval($index+1).'_url', $s->url, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    @endforeach
                                    @for ($i = $vc->showcases->count() + 1; $i <= 5; $i++)
                                    <legend>投资案例 {{ $i }}</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">案例名称</label>
                                        <div class="col-md-9">
                                            {{ Form::text('showcase_'.strval($i).'_title', '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">案例内容</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('showcase_'.strval($i).'_content', '', array('class' => 'form-control', 'rows' => '6')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">跳转链接</label>
                                        <div class="col-md-9">
                                            {{ Form::text('showcase_'.strval($i).'_url', '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    @endfor
                                    @else
                                    @for ($i = 1; $i <= 5; $i++)
                                    <legend>投资案例 {{ $i }}</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">案例名称</label>
                                        <div class="col-md-9">
                                            {{ Form::text('showcase_'.strval($i).'_title', '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">案例内容</label>
                                        <div class="col-md-9">
                                            {{ Form::textarea('showcase_'.strval($i).'_content', '', array('class' => 'form-control', 'rows' => '6')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">跳转链接</label>
                                        <div class="col-md-9">
                                            {{ Form::text('showcase_'.strval($i).'_url', '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    @endfor
                                    @endif
                                </fieldset>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-save"></i>
                                                @if (isset($vc))
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