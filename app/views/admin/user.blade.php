@extends('admin.templates.base')

@section('breadcrumb')
<li>其他管理</li>
<li>会员管理</li>
@stop

@section('content')
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> 其他管理 <span>&gt; 会员管理 </span></h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
	    <a data-toggle="modal" href="{{ route('admin.user.new') }}" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> 添加会员</a>
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

                <!-- Widget ID (each widget will need unique ID)-->

                <!-- end widget -->

                <!-- Widget ID (each widget will need unique ID)-->

                <!-- end widget -->

                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget" style="">
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>会员管理</h2>
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
                                            {{ Form::text('search', $input['search'], array('class' => 'form-control input-sm', 'placeholder' => '输入您要搜索的内容')); }}
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">应用</button>
                                    </fieldset>
                                </form>
                            </div>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">用户名</th>
                                        <th class="col-md-1">Email</th>
                                        <th class="col-md-1">用户权限</th>
                                        <th class="col-md-1">角色</th>
                                        <th class="col-md-1">姓名</th>
                                        <th class="col-md-1">联系方式</th>
                                        <th class="col-md-1">公司</th>
                                        <th class="col-md-1">网站</th>
                                        <th class="col-md-1">上次登陆</th>
                                        <th class="col-md-1">注册时间</th>
                                        <th class="col-md-1">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td><a href="mailto::{{ $user->email }}">{{ $user->email }}</a></td>
                                        <td>
                                            @if (Sentry::findUserByID($user->id)->inGroup(Sentry::findGroupByName('admin')))
                                                <strong>管理员</strong>
                                            @elseif (Sentry::findUserByID($user->id)->inGroup(Sentry::findGroupByName('normal')))
                                                普通用户
                                            @endif
                                        </td>
                                        <td>{{ $user->job }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->contact }}</td>
                                        <td>{{ $user->company }}</td>
                                        <td><a href="{{ $user->website }}">{{ $user->website }}</a></td>
                                        <td>{{ $user->last_login }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-success btn-xs">编辑</a>
                                            <a class="btn btn-danger btn-xs ajax-delete" data-id="{{ $user->id }}">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        {{ $users->appends(array('search' => $input['search']))->links() }}
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

    $(".ajax-delete").click(function(e) {
        var id = $(this).data('id');

        $.SmartMessageBox({
            title : "确认删除",
            content : "您确认要删除该条记录吗？",
            buttons : '[取消][确认]'
        }, function(ButtonPressed) {
                if (ButtonPressed === "确认") {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.user.ajax.delete') }}/" + id,
                        dataType: "json",
                        async: "true",
                        success: function(data, textStatus){
                            location.reload();
                        }, error: function(data){
                            $.smallBox({
                                title : "发生错误",
                                content : "在发送请求时出现错误，请刷新页面后重试",
                                color : "#C46A69",
                                iconSmall : "fa fa-lock fa-2x fadeInRight animated",
                                timeout : 4000
                            });
                        }
                    });
                }
                if (ButtonPressed === "取消") {

                }

            });
            e.preventDefault();
        });
    });
</script>
@stop