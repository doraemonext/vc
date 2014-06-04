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
                    @foreach ($rating_category as $category)
                    @if ($category->id == 1)
                    <li class="vctotal">
                    @else
                    <li>
                    @endif
                        <span class="vcbar_head">{{ $category->title }}</span>
                        <span class="vcscore">{{ $rating[$category->id] }}</span>
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
                <li class="score1">
                    <span class="star_label">沟通顺畅</span>
                    <span class="stars_item">
                        <label>
                            <input type="radio" value="0.5" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="1.0" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="1.5" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="2.0" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="2.5" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="3.0" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="3.5" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="4.0" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="4.5" name="score1">
                        </label>
                        <label>
                            <input type="radio" value="5.0" name="score1">
                        </label>
                        <span class="star_bg"></span></span>
                        <span class="score_value"></span>
                </li>
                <li class="score2">
                    <span class="star_label">权益合理</span>
                    <span class="stars_item">
                        <label>
                            <input type="radio" value="0.5" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="1.0" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="1.5" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="2.0" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="2.5" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="3.0" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="3.5" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="4.0" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="4.5" name="score2">
                        </label>
                        <label>
                            <input type="radio" value="5.0" name="score2">
                        </label>
                        <span class="star_bg"></span></span>
                        <span class="score_value"></span>
                </li>
                <li class="score3">
                    <span class="star_label">投资效率</span>
                    <span class="stars_item">
                        <label>
                            <input type="radio" value="0.5" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="1.0" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="1.5" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="2.0" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="2.5" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="3.0" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="3.5" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="4.0" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="4.5" name="score3">
                        </label>
                        <label>
                            <input type="radio" value="5.0" name="score3">
                        </label>
                        <span class="star_bg"></span></span>
                        <span class="score_value"></span>
                </li>
                <li class="score4">
                    <span class="star_label">资源协助</span>
                    <span class="stars_item">
                        <label>
                            <input type="radio" value="0.5" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="1.0" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="1.5" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="2.0" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="2.5" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="3.0" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="3.5" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="4.0" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="4.5" name="score4">
                        </label>
                        <label>
                            <input type="radio" value="5.0" name="score4">
                        </label>
                        <span class="star_bg"></span></span>
                        <span class="score_value"></span>
                </li>
            </ul>
            <a class="grade_submit" href="">提交评分</a>
            <div class="clear"></div>
        </div>
        <div class="comment_box">
            <div class="comment_info">
                <span class="comment_count">项目评论({{ $comment_count }})</span>
                <a class="comment_like" href="">赞({{ $vc->vote }})<span class="icon_like"></span></a>
            </div>
            <textarea class="comment_text">你怎么看？</textarea>
            <div class="alert alert_error">error<button class="close">x</button></div>
            <div class="alert alert_success">success<button class="close">x</button></div>
            <div class="alert alert_info">info<button class="close">x</button></div>
            <div class="comment_undertext">
                <a class="user left" href="">
                    <span class="user_name">{{ $user->username }}</span>
                    <img class="user_photo" src="{{ Gravatar::src($user->email, 36) }}">
                </a>
                <a class="comment_submit right" href="">提交评论</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="comment_comments">
            @foreach ($comment_paginate as $index => $comment)
            <div class="comment_item">
                <div class="comment_userphoto">
                    <a href=""><img src="{{ Gravatar::src($user->email, 50) }}"></a>
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