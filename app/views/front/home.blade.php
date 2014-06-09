@extends('front.templates.base')

@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('front/css/index.css') }}">
@stop

@section('slider')
<div id="ad_slider">
    <div id="ad_slider_container">
        <div id="carousel-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-generic" data-slide-to="1"></li>
                <li data-target="#carousel-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" id="ad_slider_imgs">
                <div class="item active">
                    <a href="" style="background-image:url({{ asset('front/images/ad_slider1.png') }})"></a>
                </div>
                <div class="item">
                    <a href="" style="background-image:url({{ asset('front/images/ad_slider2.png') }})"></a>
                </div>
                <div class="item">
                    <a href="" style="background-image:url({{ asset('front/images/ad_slider3.png') }})"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <span class="ad_data">已入驻VC {{ $count['vc'] }}</span>
        <span class="ad_data">已入驻联合创始人 {{ $count['user'] }}</span>
        <span class="ad_data">已有评论 {{ $count['vc_comment'] }}</span>
    </div>
</div>
@stop

@section('leftbar')
<div id="leftbar">
    <div class="column_side">
        <div class="column_side_head">
            <div class="column_side_title">推荐投资方</div>
        </div>
        <div class="column_content">
            @foreach ($vc_recommend as $vc)
            <div class="investor_item">
                <a class="item_investor" href="{{ route('vc.item', $vc->id) }}">
                    <div class="investor_head">
                        <span class="investor_name">{{ $vc->name }}</span>
                        <span class="investor_update">{{ date('m/d', strtotime($vc->updated_at)) }} 更新</span>
                    </div>
                    <div class="investor_content">
                        <div class="investor_mscore">
                            <div class="investor_tscore">{{ round($vc->rating, 1) }}</div>
                            <div class="investor_np">{{ $vc->ratings()->count() }}人打分</div>
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
            <div class="column_side_title">投资方排名</div>
        </div>
        <div class="column_content">
            @foreach ($vc_list as $vc)
            <div class="investor_item">
                <a class="item_investor" href="{{ route('vc.item', $vc->id) }}">
                    <div class="investor_head">
                        <span class="investor_name">{{ $vc->name }}</span>
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
        <div class="page sidepage">
            <ul>
                <li class="prevpage disabled"><a href="#">上一页</a></li>
                <li class="nextpage"><a href="">下一页</a></li>
            </ul>
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
            <div class="column_main_title">推荐项目 Good Project</div>
        </div>
        <div class="column_content project_slider">
            <div class="project_slider_container">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach ($vc_recommend as $index => $vc)
                        @if ($index == 0)
                        <li data-target="#carousel-example-generic" data-slide-to="{{ $index }}" class="active"></li>
                        @else
                        <li data-target="#carousel-example-generic" data-slide-to="{{ $index }}"></li>
                        @endif
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @foreach ($vc_recommend as $index => $vc)
                        @if ($index == 0)
                        <div class="item active">
                        @else
                        <div class="item">
                        @endif
                            <img src="{{ asset($config_upload['vc.logo'].$vc->logo.'-526x320') }}">
                            <div class="carousel-caption">
                                <div class="project_title"><a href="{{ route('vc.item', $vc->id) }}">{{ $vc->name }}</a></div>
                                <div class="project_subtitle">{{ mb_substr($vc->summary, 0, 50, 'utf-8') }}...</div>
                                <div class="project_info">{{ $vc->datetime }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
            <div class="project_description">
            </div>
        </div>
    </div>
    <div class="center_ad">
        <a href="">
            <img src="{{ asset('front/images/center_ad.png') }}">
        </a>
    </div>
    <div class="column_main">
        <div class="column_main_head">
            <div class="column_main_title">新闻 News</div>
        </div>
        <div class="column_content">
            @foreach ($news_latest as $latest)
            <div class="news_item">
                <div class="news_left">
                    <a href="{{ route('news.item', $latest->id) }}"><img src="{{ Croppa::url($config_upload['news.picture'].$latest->picture, 160, 110) }}"></a>
                    <a class="news_forward" title="回应人数" href="{{ route('news.item', $latest->id) }}">
                        <span class="icon icon_forward"></span>
                        {{ $latest->comment_count }}
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="{{ route('news.item', $latest->id) }}">{{ $latest->title }}</a></div>
                    <div class="news_subtitle">{{ mb_substr($latest->summary, 0, 50, 'utf-8') }}...</div>
                    <div class="news_info">{{ $latest->datetime }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="page">
        <ul>
            <li class="prevpage disabled"><a href="#">上一页</a></li>
            <li class="disabled"><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href="">5</a></li>
            <li class="nextpage"><a href="">下一页</a></li>
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
                    <a href="{{ route('news.item', $hot->id) }}"><img src="{{ Croppa::url($config_upload['news.picture'].$hot->picture, 60, 60) }}"></a>
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
