@extends('user.templates.base')

@section('page_title')
-个人设置
@stop

@section('breadcrumb')
<li>个人设置</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 个人设置 </h1>
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
                        <h2>个人设置</h2>
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
                            {{ Form::open(array('action' => array('UserSettingController@submitSetting'), 'class' => 'form-horizontal')) }}
                                <fieldset>
                                    <legend>安全信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">原密码<span class="text-danger"> * </span></label>
                                        <div class="col-md-9">
                                            {{ Form::password('old_password', array('class' => 'form-control')) }}
                                            <div class="help-block"><strong>必填项，修改下面所有信息均需要您在此输入正确的密码</strong></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">新密码</label>
                                        <div class="col-md-9">
                                            {{ Form::password('new_password', array('class' => 'form-control')) }}
                                            <div class="help-block">如果您需要修改密码，请填写此项，否则请留空</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">确认新密码</label>
                                        <div class="col-md-9">
                                            {{ Form::password('confirm_password', array('class' => 'form-control')) }}
                                            <div class="help-block">如果您需要修改密码，请填写此项，否则请留空</div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">用户名<span class="text-danger"> * </span></label>
                                        <div class="col-md-9">
                                            <input class="form-control" disabled="disabled" placeholder="{{ $user->username }}" type="text">
                                            <div class="help-block">用户名默认不可修改，如需修改请联系管理员</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">电子邮箱<span class="text-danger"> * </span></label>
                                        <div class="col-md-9">
                                            {{ Form::email('email', $user->email, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>扩展信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">角色</label>
                                        <div class="col-md-9">
                                            {{ Form::text('job', $user->job, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">姓名</label>
                                        <div class="col-md-9">
                                            {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">联系方式</label>
                                        <div class="col-md-9">
                                            {{ Form::text('contact', $user->contact, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">所在单位</label>
                                        <div class="col-md-9">
                                            {{ Form::text('company', $user->company, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">网站</label>
                                        <div class="col-md-9">
                                            {{ Form::text('website', $user->website, array('class' => 'form-control')) }}
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