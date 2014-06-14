@extends('front.templates.base')

@section('page_title')
-轶闻
@stop

@section('leftbar')
    <div id="leftbar">
        <div class="column_side">
            <div class="column_side_head">
                <div class="column_side_title b_title" id="comment">推荐投资方</div>
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
                <div class="column_main_title">圈内轶闻 Stories</div>
            </div>
            <div class="column_content">
                @foreach ($news_list as $news)
                <div class="news_item">
                    <div class="news_left">
                        <a href="{{ route('news.item', $news->id) }}"><img src="{{ Croppa::url($config_upload['news.picture'].$news->picture, 140, 140) }}"></a>
                    </div>
                    <div class="news_right">
                        <div class="news_title"><a href="{{ route('news.item', $news->id) }}">{{ $news->title }}</a></div>
                        <div class="news_subtitle">{{ $news->summary }}</div>
                        <div class="news_info">{{ $news->datetime }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="page">
            <ul>
                @if ($news_list->getCurrentPage() - 1 > 0)
                <li class="prevpage"><a href="{{ $news_list->getUrl($news_list->getCurrentPage() - 1) }}">上一页</a></li>
                @else
                <li class="prevpage disabled"><a href="##">上一页</a></li>
                @endif

                @for ($i = $news_list->getCurrentPage() - 2; $i <= $news_list->getCurrentPage() + 2; $i++)
                @if ($i > 0 && $i <= $news_list->getLastPage())
                    @if ($i == $news_list->getCurrentPage())
                        <li class="disabled"><a href="##">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $discuss_list->getUrl($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
                @endfor

                @if ($news_list->getCurrentPage() < $news_list->getLastPage())
                <li class="nextpage"><a href="{{ $news_list->getUrl($news_list->getCurrentPage() + 1) }}">下一页</a></li>
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
                <div class="column_side_title red_title">热门轶闻</div>
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