@extends('front.templates.base')

@section('page_title')
-讨论区
@stop

@section('leftbar')
    <div id="leftbar">
        <div class="column_side">
            <div class="column_side_head">
                <div class="column_side_title">话题更新</div>
            </div>
            <div class="column_content">
                @foreach ($discuss_latest as $latest)
                <div class="newproj_item">
                    <a href="{{ route('discuss.item', $latest->id) }}">{{ $latest->title }}</a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="clear"></div>
        <div class="code_2d">
            <img src="{{ asset('front/images/code_2d.png') }}">
        </div>
    </div>
@stop

@section('mainbar')
    <div id="mainbar">
        <div class="column_main">
            <div class="column_main_head">
                <div class="column_main_title">讨论区 Forum</div>
            </div>
            <div class="column_content">
                @foreach ($discuss_list as $discuss)
                <a class="discuss_item" href="{{ route('discuss.item', $discuss->id) }}">
                    <div class="discuss_title">{{ $discuss->title }}</div>
                    <div class="discuss_content">{{ $discuss->content }}</div>
                    <div class="discuss_info">
                        <span class="discuss_reply">回复({{ $discuss->comment_count }})</span>
                        <span class="discuss_like">赞({{ $discuss->vote }})</span>
                        <span class="discuss_date">{{ $discuss->user->username }} {{ $discuss->datetime }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        <div class="page">
            <ul>
                @if ($discuss_list->getCurrentPage() - 1 > 0)
                <li class="prevpage"><a href="{{ $discuss_list->getUrl($discuss_list->getCurrentPage() - 1) }}">上一页</a></li>
                @else
                <li class="prevpage disabled"><a href="##">上一页</a></li>
                @endif

                @for ($i = $discuss_list->getCurrentPage() - 2; $i <= $discuss_list->getCurrentPage() + 2; $i++)
                @if ($i > 0 && $i <= $discuss_list->getLastPage())
                    @if ($i == $discuss_list->getCurrentPage())
                        <li class="disabled"><a href="##">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $discuss_list->getUrl($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
                @endfor

                @if ($discuss_list->getCurrentPage() < $discuss_list->getLastPage())
                <li class="nextpage"><a href="{{ $discuss_list->getUrl($discuss_list->getCurrentPage() + 1) }}">下一页</a></li>
                @else
                <li class="nextpage disabled"><a href="##">下一页</a></li>
                @endif
            </ul>
        </div>
        <div id="post">
            <div class="post_head">发表新的讨论</div>
            <input class="post_title_text" type="text" placeholder="请输入标题">
            <textarea class="post_text" placeholder="请输入内容"></textarea>
            <div class="post_undertext">
                @if (isset($user))
                <a class="user left" href="">
                    <span class="user_name">{{ $user->username }}</span>
                    <img class="user_photo" src="{{ Gravatar::src($user->email, 36) }}">
                </a>
                <a class="post_submit right" href="">提交评论</a>
                @else
                <span>没有账号？</span>
                <a class="register" href="{{ route('register') }}">注册&gt;&gt;</a>
                <a class="login" href="{{ route('login') }}">登录</a>
                <span class="right">登录后可以评论</span>
                @endif
            </div>
        </div>
    </div>
@stop

@section('rightbar')
    <div id="rightbar">
        <div class="column_side">
            <div class="column_side_head">
                <div class="column_side_title">最热话题</div>
            </div>
            <div class="column_content hottopic">
                @foreach ($discuss_hot as $hot)
                <a class="topic_item" href="{{ route('discuss.item', $hot->id) }}">
                    <div class="topic_title">{{ $hot->title }}</div>
                        <div class="topic_content">{{ $hot->content }}</div>
                    <div class="topic_info">赞({{ $hot->vote }}) 回复({{ $hot->comment_count }}) {{ $hot->datetime }}</div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('custom_js')
<script type="text/javascript">
$(document).ready(function() {
    @if (Session::has('status'))
    msg_top("{{ Session::get('message') }}", "{{ Session::get('status') }}");
    @endif
});
</script>
@stop