@extends('front.templates.base')

@section('custom_css')

@stop

@section('leftbar')
<div id="leftbar">
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title">VC动态</div>
        </div>
        <div class="column_content">
            <div class="newproj_item">
                <a href="">机器人eden问世，世界上第一款仿生学机器人</a>
            </div>
            <div class="newproj_item">
                <a href="">懒人电脑桌，专为懒人设计</a>
            </div>
            <div class="newproj_item">
                <a href="">懒人电脑桌，专为懒人设计</a>
            </div>
            <div class="newproj_item">
                <a href="">懒人电脑桌，专为懒人设计</a>
            </div>
            <div class="newproj_item">
                <a href="">机器人eden问世，世界上第一款仿生学机器人</a>
            </div>
            <div class="newproj_item">
                <a href="">懒人电脑桌，专为懒人设计</a>
            </div>
            <div class="newproj_item">
                <a href="">机器人eden问世，世界上第一款仿生学机器人</a>
            </div>
            <div class="newproj_item">
                <a href="">机器人eden问世，世界上第一款仿生学机器人</a>
            </div>
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
            <div class="vcitem_title">{{ $vc->name }}</div>
            <div class="vcitem_condition">
                <div class="vc_img">
                    <a href="{{ $vc->website }}"><img src="{{ asset($config_upload['vc.logo'].$vc->logo) }}" height="140" width="140"></a>
                </div>
                <ul class="vc_score">
                    <li class="vctotal">
                        <span class="vcbar_head">总分</span>
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
            <div class="vcitem_article">
                <div class="vcitem_content">
                    {{ $vc->content }}
                </div>
            </div>
        </div>
    </div>
    @if (isset($user))
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
            <div id="comment_error" class="alert alert_error" style="display: none"></div>
            @if (Session::has('status'))
            <div class="alert alert_{{ Session::get('status') }}">
                <button class="close">x</button>
                {{ Session::get('message') }}
            </div>
            @endif
            <div class="comment_undertext">
                <a class="user left" href="">
                    <span class="user_name">{{ $user->username }}</span>
                    <img class="user_photo" src="{{ Gravatar::src($user->email, 36) }}">
                </a>
                <button class="comment_submit right" id="comment_submit">提交评论</button>
            </div>
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
    @endif
</div>
@stop

@section('rightbar')
<div id="rightbar">
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title">投资案例</div>
        </div>
        <div class="column_content investment">
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
            </a>
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
            </a>
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
            </a>
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
            </a>
            <a class="topic_item" href="">
                <div class="topic_title">这是话题的题目这是话题的题目这是话题的题目</div>
                <div class="topic_content">这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的内容这是话题的</div>
            </a>
        </div>
    </div>
</div>
@stop

@section('custom_js')
<script type="text/javascript">
$(document).ready(function() {
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
                    $("#comment_error").html(content);
                    $("#comment_error").css('display', 'block');
                } else {
                    $("#comment_error").css('display', 'none');
                    location.reload();
                }
            }, error: function(data) {
                $("#comment_error").html('网络错误，请刷新页面后重试');
                $("#comment_error").css('display', 'block');
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
                    $("#comment_error").html(data['message']);
                    $("#comment_error").css('display', 'block');
                } else {
                    $("#comment_error").css('display', 'none');
                    location.reload();
                }
            }, error: function(data) {
                $("#comment_error").html('网络错误，请刷新页面后重试');
                $("#comment_error").css('display', 'block');
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
                    $("#comment_error").html(data['message']);
                    $("#comment_error").css('display', 'block');
                } else {
                    $("#comment_error").css('display', 'none');
                    $("#vote_count").html(data['vote_count']);
                }
            }, error: function(data) {
                $("#comment_error").html('网络错误，请刷新页面后重试');
                $("#comment_error").css('display', 'block');
            }
        });
    });
});
</script>
@stop
