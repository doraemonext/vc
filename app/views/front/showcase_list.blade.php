@extends('front.templates.base')

@section('leftbar')
    <div id="leftbar">
        <div class="column_side">
            <div class="column_side_head">
                <div class="column_side_title">推荐投资方</div>
            </div>
            <div class="column_content">
                <div class="investor_item">
                    <a class="item_investor" href="">
                        <div class="investor_head">
                            <span class="investor_name">红杉资本</span>
                            <span class="investor_update">6/1 更新</span>
                        </div>
                        <div class="investor_content">
                            <div class="investor_mscore">
                                <div class="investor_tscore">4.5</div>
                                <div class="investor_np">249人打分</div>
                            </div>
                            <ul class="investor_detail">
                                <li>沟通顺畅 4.2</li>
                                <li>权益合理 4.1</li>
                                <li>投资效率 4.0</li>
                                <li>资源协助 4.9</li>
                            </ul>
                        </div>
                    </a>
                </div>
                <div class="investor_item">
                    <a class="item_investor" href="">
                        <div class="investor_head">
                            <span class="investor_name">红杉资本</span>
                            <span class="investor_update">6/1 更新</span>
                        </div>
                        <div class="investor_content">
                            <div class="investor_mscore">
                                <div class="investor_tscore">4.5</div>
                                <div class="investor_np">249人打分</div>
                            </div>
                            <ul class="investor_detail">
                                <li>沟通顺畅 4.2</li>
                                <li>权益合理 4.1</li>
                                <li>投资效率 4.0</li>
                                <li>资源协助 4.9</li>
                            </ul>
                        </div>
                    </a>
                </div>
                <div class="investor_item">
                    <a class="item_investor" href="">
                        <div class="investor_head">
                            <span class="investor_name">红杉资本</span>
                            <span class="investor_update">6/1 更新</span>
                        </div>
                        <div class="investor_content">
                            <div class="investor_mscore">
                                <div class="investor_tscore">4.5</div>
                                <div class="investor_np">249人打分</div>
                            </div>
                            <ul class="investor_detail">
                                <li>沟通顺畅 4.2</li>
                                <li>权益合理 4.1</li>
                                <li>投资效率 4.0</li>
                                <li>资源协助 4.9</li>
                            </ul>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="column_side">
            <div class="column_side_head">
                <div class="column_side_title">投资方排名</div>
            </div>
            <div class="column_content">
                <div class="investor_item">
                    <a class="item_investor" href="">
                        <div class="investor_head">
                            <span class="investor_name">红杉资本</span>
                            <span class="investor_update">6/1 更新</span>
                        </div>
                        <div class="investor_content">
                            <div class="investor_mscore">
                                <div class="investor_tscore">4.5</div>
                                <div class="investor_np">249人打分</div>
                            </div>
                            <ul class="investor_detail">
                                <li>沟通顺畅 4.2</li>
                                <li>权益合理 4.1</li>
                                <li>投资效率 4.0</li>
                                <li>资源协助 4.9</li>
                            </ul>
                        </div>
                    </a>
                </div>
                <div class="investor_item">
                    <a class="item_investor" href="">
                        <div class="investor_head">
                            <span class="investor_name">红杉资本</span>
                            <span class="investor_update">6/1 更新</span>
                        </div>
                        <div class="investor_content">
                            <div class="investor_mscore">
                                <div class="investor_tscore">4.5</div>
                                <div class="investor_np">249人打分</div>
                            </div>
                            <ul class="investor_detail">
                                <li>沟通顺畅 4.2</li>
                                <li>权益合理 4.1</li>
                                <li>投资效率 4.0</li>
                                <li>资源协助 4.9</li>
                            </ul>
                        </div>
                    </a>
                </div>
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
                <div class="column_main_title">项目展示 All Project</div>
            </div>
            <div class="column_content">
                @foreach ($showcase_list as $showcase)
                <div class="project_item">
                    <div class="project_img">
                        <a href="{{ route('showcase.item', $showcase->id) }}"><img src="{{ Croppa::url($config_upload['showcase.logo'].$showcase->logo, 526, 320) }}"></a>
                    </div>
                    <div class="project_description">
                        <div class="project_title"><a href="{{ route('showcase.item', $showcase->id) }}">{{ $showcase->name }}</a></div>
                        <div class="project_subtitle">
                            @if (mb_substr($showcase->summary, 0, 50, 'utf-8') != $showcase->summary)
                            {{ mb_substr($showcase->summary, 0, 50, 'utf-8') }}...
                            @else
                            {{ mb_substr($showcase->summary, 0, 50, 'utf-8') }}
                            @endif
                        </div>
                        <div class="project_info"><a class="project_like" href="">赞({{ $showcase->vote }})</a>{{ $showcase->datetime }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="page">
            <ul>
                @if ($showcase_list->getCurrentPage() - 1 > 0)
                <li class="prevpage"><a href="{{ $showcase_list->getUrl($showcase_list->getCurrentPage() - 1) }}">上一页</a></li>
                @else
                <li class="prevpage disabled"><a href="##">上一页</a></li>
                @endif

                @for ($i = $showcase_list->getCurrentPage() - 2; $i <= $showcase_list->getCurrentPage() + 2; $i++)
                @if ($i > 0 && $i <= $showcase_list->getLastPage())
                    @if ($i == $showcase_list->getCurrentPage())
                        <li class="disabled"><a href="##">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $showcase_list->getUrl($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
                @endfor

                @if ($showcase_list->getCurrentPage() < $showcase_list->getLastPage())
                <li class="nextpage"><a href="{{ $showcase_list->getUrl($showcase_list->getCurrentPage() + 1) }}">下一页</a></li>
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

@section('custom_js')
<script type="text/javascript">
$(document).ready(function() {
    @if (Session::has('status'))
    msg_top("{{ Session::get('message') }}", "{{ Session::get('status') }}");
    @endif
});
</script>
@stop