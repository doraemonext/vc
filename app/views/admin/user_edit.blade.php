@extends('admin.templates.base')

@section('breadcrumb')
<li>其他管理</li>
@if (isset($edit_user))
<li>编辑会员</li>
@else
<li>添加会员</li>
@endif
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            @if (isset($edit_user))
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 编辑会员 </span></h1>
            @else
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 添加会员 </span></h1>
            @endif
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a data-toggle="modal" href="{{ route('admin.user') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 返回会员列表</a>
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
                        @if (isset($edit_user))
                        <h2>编辑会员</h2>
                        @else
                        <h2>添加会员</h2>
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
                            @if (isset($edit_user))
                            {{ Form::open(array('action' => array('AdminUserController@submitEdit', $edit_user->id), 'class' => 'form-horizontal')) }}
                            @else
                            {{ Form::open(array('action' => 'AdminUserController@submitNew', 'class' => 'form-horizontal')) }}
                            @endif
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">用户名</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user))
                                            {{ Form::text('username', $edit_user->username, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('username', isset($edit_username) ? $edit_username : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Email</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user))
                                            {{ Form::text('email', $edit_user->email, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('email', isset($email) ? $email : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>权限信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">新密码</label>
                                        <div class="col-md-9">
                                            {{ Form::password('password', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">确认新密码</label>
                                        <div class="col-md-9">
                                            {{ Form::password('confirm_password', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">用户权限</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user) && Sentry::findUserByID($edit_user->id)->inGroup(Sentry::findGroupByName('admin')))
                                            {{ Form::select('group', array('normal' => '普通用户', 'admin' => '管理员'), 'admin', array('class' => 'form-control')) }}
                                            @elseif (isset($edit_user) && Sentry::findUserByID($edit_user->id)->inGroup(Sentry::findGroupByName('normal')))
                                            {{ Form::select('group', array('normal' => '普通用户', 'admin' => '管理员'), 'normal', array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::select('group', array('normal' => '普通用户', 'admin' => '管理员'), 'normal', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>扩展信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">角色</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user))
                                            {{ Form::text('job', $edit_user->job, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('job', isset($job) ? $job : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">姓名</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user))
                                            {{ Form::text('name', $edit_user->name, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('name', isset($name) ? $name : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">联系方式</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user))
                                            {{ Form::text('contact', $edit_user->contact, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('contact', isset($contact) ? $contact : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">公司</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user))
                                            {{ Form::text('company', $edit_user->company, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('company', isset($company) ? $company : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">网站</label>
                                        <div class="col-md-9">
                                            @if (isset($edit_user))
                                            {{ Form::text('website', $edit_user->website, array('class' => 'form-control')) }}
                                            @else
                                            {{ Form::text('website', isset($website) ? $website : '', array('class' => 'form-control')) }}
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-save"></i>
                                                @if (isset($edit_user))
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
});
</script>
@stop