@extends('front.templates.base')

@section('page_title')
-VC-{{ $vc->name }}
@stop

@section('custom_css')

@stop

@section('leftbar')
<div id="leftbar">
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title b_title" id="comment">推荐投资方</div>
        </div>
        <div class="column_content">
            @foreach ($vc_recommend as $v)
            <div class="investor_item">
                <a class="item_investor" href="{{ route('vc.item', $v->id) }}">
                    <div class="investor_head">
                        <span class="investor_name red_title">
                            @if (mb_substr($v->name, 0, 13, 'utf-8') != $v->name)
                            {{ mb_substr($v->name, 0, 13, 'utf-8') }}...
                            @else
                            {{ mb_substr($v->name, 0, 13, 'utf-8') }}
                            @endif
                        </span>
                    </div>
                    <div class="investor_content">
                        <div class="investor_mscore">
                            <div class="investor_tscore">{{ round($v->rating, 1) }}</div>
                            <div class="investor_np">{{ $v->ratings()->where('vc_rating_category_id', '=', 1)->count() }}人打分</div>
                        </div>
                        <ul class="investor_detail">
                            @foreach ($rating_category as $category)
                            <li>{{ $category->title }} {{ round($v->score[$category->id], 1) }}</li>
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
            <div class="column_side_title">VC动态</div>
        </div>
        <div class="column_content">
            @foreach ($news_list as $news)
            <div class="newproj_item">
                <a href="{{ route('news.item', $news->id) }}">{{ $news->title }}</a>
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
            <div class="column_main_title">VC信息 Information of VC</div>
        </div>
        <div class="column_content vcitem">
            <div class="vcitem_article">
                <div class="vcitem_title">{{ $vc->name }}</div>
                <div class="vcitem_condition">
                    <div class="vc_img">
                        <a href="{{ $vc->website }}"><img src="{{ Croppa::url($config_upload['vc.logo'].$vc->logo, 140, 140) }}"></a>
                    </div>
                    <ul class="vc_score">
                        <li class="vctotal">
                            <span class="vcbar_head">综合</span>
                            <span class="vcscore">{{ round($rating[0], 1) }}</span>
                            <span class="vc_bar" style="width:{{ $rating[0] * 18 }}px"></span>
                        </li>
                        @foreach ($rating_category as $category)
                        <li>
                            <span class="vcbar_head">{{ $category->title }}</span>
                            <span class="vcscore">{{ round($rating[$category->id], 1) }}</span>
                            <span class="vc_bar" style="width:{{ $rating[$category->id] * 18 }}px"></span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="vcitem_content">
                    {{ $vc->content }}
                </div>
            </div>
        </div>
    </div>

    <div id="comment">
        <div class="grade">
            <div class="grade_title">你的评分：</div>
            <ul class="stars">
                @foreach ($rating_category as $category)
                <li class="score{{ $category->id }}">
                    <span class="star_label">{{ $category->title }}</span>
                    <span class="stars_item">
                        @for ($i = 1; $i <= 50; $i++)
                        <label>
                            <input type="radio" value="{{ round($i * 0.1, 1) }}" name="rating_{{ $category->id }}">
                        </label>
                        @endfor
                        <span class="star_bg"></span></span>
                        <span class="score_value"></span>
                </li>
                @endforeach
            </ul>
            <button class="grade_submit" id="rating_submit">提交评分</button>
            <div class="clear"></div>
        </div>
        <div class="comment_box">
            <div class="comment_info">
                <span class="comment_count">项目评论({{ $comment_count }})</span>
                <a class="comment_like" id="vote" href="##">赞(<span id="vote_count">{{ $vc->vote }}</span>)<span class="icon_like"></span></a>
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
                        <a href="##">{{ ($comment_paginate->getCurrentPage() - 1) * $comment_paginate->getPerPage() + $index + 1 }}楼</a>
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
            <div class="column_side_title">投资案例</div>
        </div>
        <div class="column_content investment">
            @foreach ($vc->showcases as $s)
            <a class="topic_item" href="{{ $s->url }}">
                <div class="topic_title">{{ $s->title }}</div>
                <div class="topic_content">{{ $s->content }}</div>
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
    msg("{{ Session::get('message') }}", "{{ Session::get('status') }}");
    @endif

    $("#comment_submit").click(function() {
        $.ajax({
            type: "POST",
            url: "{{ route('vc.item.ajax.comment.submit', $vc->id) }}",
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

    $("#rating_submit").click(function() {
        $.ajax({
            type: "POST",
            url: "{{ route('vc.item.ajax.rating', $vc->id) }}",
            data: {
                @foreach ($rating_category as $category)
                rating_{{ $category->id }}: $("input[name=rating_{{ $category->id }}]:checked").val(),
                @endforeach
            },
            dataType: "json",
            success: function(data, textStatus) {
                if (data['code'] != 0) {
                    msg(data['message'], 'error');
                } else {
                    location.reload();
                }
            }, error: function(data) {
                msg('网络错误，请刷新页面后重试', 'error');
             }
        });
    });

    $("#vote").click(function() {
        $.ajax({
            type: "POST",
            url: "{{ route('vc.item.ajax.vote', $vc->id) }}",
            dataType: "json",
            success: function(data, textStatus) {
                if (data['code'] != 0) {
                    msg(data['message'], 'error');
                } else {
                    $("#vote_count").html(data['vote_count']);
                }
            }, error: function(data) {
                msg('网络错误，请刷新页面后重试', 'error');
            }
        });
    });
});
</script>
@stop
