@extends('front/templates/base')

@section('page_title')
-新闻-{{ $news->title }}
@stop

@section('leftbar')
<div id="leftbar">
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title b_title">推荐投资方</div>
        </div>
        <div class="column_content">
            @foreach ($vc_recommend as $vc)
            <div class="investor_item">
                <a class="item_investor" href="{{ route('vc.item', $vc->id) }}">
                    <div class="investor_head">
                        <span class="investor_name red_title">
                            @if (mb_substr($vc->name, 0, 13, 'utf-8') != $vc->name)
                            {{ mb_substr($vc->name, 0, 13, 'utf-8') }}...
                            @else
                            {{ mb_substr($vc->name, 0, 13, 'utf-8') }}
                            @endif
                        </span>
                        <span class="investor_update">{{ date('m/d', strtotime($vc->updated_at)) }} 更新</span>
                    </div>
                    <div class="investor_content">
                        <div class="investor_mscore">
                            <div class="investor_tscore">{{ round($vc->rating, 1) }}</div>
                            <div class="investor_np">{{ $vc->ratings()->where('vc_rating_category_id', '=', 1)->count() }}人打分</div>
                        </div>
                        <ul class="investor_detail">
                            @foreach ($rating_category as $category)
                            <li>{{ $category->title }} {{ round($vc->score[$category->id], 1) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title">最新项目</div>
        </div>
        <div class="column_content">
            @foreach ($showcase_latest as $latest)
            <div class="newproj_item">
                <a href="{{ route('showcase.item', $latest->id) }}">{{ $latest->name }}</a>
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
            <div class="column_main_title">新闻 News</div>
        </div>
        <div class="column_content newsitem">
            <div class="newsitem_article">
                <div class="newsitem_img">
                    <img src="{{ Croppa::url($config_upload['news.picture'].$news->picture, 508, 320) }}">
                </div>
                <div class="newsitem_title">{{ $news->title }}</div>
                <div class="newsitem_content">
                    {{ $news->content }}
                </div>
                <div class="newsitem_info">
                    {{ $news->datetime }}
                </div>
            </div>
        </div>
    </div>
    <div id="comment">
        <div class="comment_box">
            <div class="comment_info">
                <span class="comment_count">新闻评论({{ $comment_count }})</span>
            </div>
            <textarea class="comment_text" id="comment_text"></textarea>

            @if (isset($user))
            <div class="comment_undertext">
                <a class="user left" href="">
                    <span class="user_name">{{ $user->username }}</span>
                    <img class="user_photo" src="{{ Gravatar::src($user->email, 36) }}">
                </a>
                <button class="comment_submit right" id="comment_submit">提交评论</button>
            </div>
            @else
            <div class="comment_undertext">
                <span>没有账号？</span>
                <a class="register" href="{{ route('register') }}">注册&gt;&gt;</a>
                <a class="login" href="{{ route('login') }}">登录</a>
                <span class="right">登录后可以评论</span>
            </div>
            @endif

            <div class="clear"></div>
        </div>
        <div class="comment_comments">
            @foreach ($comment_paginate as $index => $comment)
            <div class="comment_item">
                <div class="comment_userphoto">
                    <a href=""><img src="{{ Gravatar::src(Sentry::findUserByID($comment->user_id)->email, 50) }}"></a>
                </div>
                <div class="comment_right">
                    <div class="comment_username">
                        <a class="username" href="">{{ Sentry::findUserByID($comment->user_id)->username }}</a>&nbsp;&nbsp;{{ $comment->datetime }}
                    </div>
                    <div class="comment_content">
                        {{ $comment->content }}
                    </div>
                    <div class="comment_floor">
                        <a href="">{{ ($comment_paginate->getCurrentPage() - 1) * $comment_paginate->getPerPage() + $index + 1 }}楼</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="page">
        <ul>
            @if ($comment_paginate->getCurrentPage() - 1 > 0)
            <li class="prevpage"><a href="{{ $comment_paginate->getUrl($comment_paginate->getCurrentPage() - 1) }}">上一页</a></li>
            @else
            <li class="prevpage disabled"><a href="##">上一页</a></li>
            @endif

            @for ($i = $comment_paginate->getCurrentPage() - 2; $i <= $comment_paginate->getCurrentPage() + 2; $i++)
            @if ($i > 0 && $i <= $comment_paginate->getLastPage())
                @if ($i == $comment_paginate->getCurrentPage())
                    <li class="disabled"><a href="##">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $comment_paginate->getUrl($i) }}">{{ $i }}</a></li>
                @endif
            @endif
            @endfor

            @if ($comment_paginate->getCurrentPage() < $comment_paginate->getLastPage())
            <li class="nextpage"><a href="{{ $comment_paginate->getUrl($comment_paginate->getCurrentPage() + 1) }}">下一页</a></li>
            @else
            <li class="nextpage disabled"><a href="##">下一页</a></li>
            @endif
        </ul>
    </div>
</div>
@stop

@section('rightbar')
<div id="rightbar">
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title">热门新闻</div>
        </div>
        <div class="column_content">
            @foreach ($news_hot as $hot)
            <div class="hotnews_item">
                <div class="hotnews_img">
                    <img src="{{ Croppa::url($config_upload['news.picture'].$hot->picture, 60, 60) }}">
                </div>
                <div class="hotnews_title">
                    <a href="{{ route('news.item', $hot->id) }}">{{ $hot->title }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title">最新话题</div>
        </div>
        <div class="column_content">
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
                <div class="topic_info">赞(13) 回复(5) 20:21</div>
            </a>
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
                <div class="topic_info">赞(13) 回复(5) 20:21</div>
            </a>
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
                <div class="topic_info">赞(13) 回复(5) 20:21</div>
            </a>
        </div>
    </div>
</div>
@stop

@section('custom_js')
<script type="text/javascript">
$(document).ready(function() {
    @if (Session::has('status'))
    msg("{{ Session::get('message') }}", "{{ Session::get('status') }}");
    @endif

    $("#comment_submit").click(function() {
        $.ajax({
            type: "POST",
            url: "{{ route('news.item.ajax.comment.submit', $news->id) }}",
            data: {
                content: $("#comment_text").val(),
            },
            dataType: "json",
            success: function(data, textStatus) {
                if (data['code'] != 0) {
                    content = '';
                    for (index = 0; index < data['message'].length; ++index) {
                        content += data['message'][index];
                    }
                    msg(content, 'error');
                } else {
                    location.reload();
                }
            }, error: function(data) {
                msg('网络错误，请刷新页面后重试', 'error');
            }
        });
    });
});
</script>
@stop