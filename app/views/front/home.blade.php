@extends('front.templates.base')

@section('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/bootstrap.css') }}">
    <script type="text/javascript" src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/index.css') }}">
@stop

@section('slider')
<div id="ad_slider">
    <div id="ad_slider_container">
        <div id="carousel-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach ($ad_top as $index => $ad)
                @if ($index == 0)
                <li data-target="#carousel-generic" data-slide-to="{{ $index }}" class="active"></li>
                @else
                <li data-target="#carousel-generic" data-slide-to="{{ $index }}"></li>
                @endif
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" id="ad_slider_imgs">
                @foreach ($ad_top as $index => $ad)
                @if ($index == 0)
                <div class="item active">
                @else
                <div class="item">
                @endif
                    <a href="{{ $ad->url }}" style="background-image:url({{ Croppa::url($config_upload['ad.picture'].$ad->picture, 1366, 260) }})"></a>
                </div>
                @endforeach
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
                        @foreach ($showcase_recommend as $index => $showcase)
                        @if ($index == 0)
                        <li data-target="#carousel-example-generic" data-slide-to="{{ $index }}" class="active"></li>
                        @else
                        <li data-target="#carousel-example-generic" data-slide-to="{{ $index }}"></li>
                        @endif
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @foreach ($showcase_recommend as $index => $showcase)
                        @if ($index == 0)
                        <div class="item active">
                        @else
                        <div class="item">
                        @endif
                            <img src="{{ Croppa::url($config_upload['showcase.logo'].$showcase->logo, 526, 320) }}">
                            <div class="carousel-caption">
                                <div class="project_title"><a href="{{ route('showcase.item', $showcase->id) }}">{{ $showcase->name }}</a></div>
                                <div class="project_subtitle">
                                    @if (mb_substr($showcase->summary, 0, 50, 'utf-8') != $showcase->summary)
                                    {{ mb_substr($showcase->summary, 0, 50, 'utf-8') }}...
                                    @else
                                    {{ mb_substr($showcase->summary, 0, 50, 'utf-8') }}
                                    @endif
                                </div>
                                <div class="project_info">{{ $showcase->datetime }}</div>
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
            @foreach ($discuss_latest as $latest)
            <a class="topic_item" href="{{ route('discuss.item', $latest->id) }}">
                <div class="topic_title">{{ $latest->title }}</div>
                <div class="topic_content">{{ $latest->content }}</div>
                <div class="topic_info">赞({{ $latest->vote }}) 回复({{ $latest->comment_count }}) {{ $latest->datetime }}</div>
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