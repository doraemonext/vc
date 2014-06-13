@extends('front.templates.base')

@section('page_title')
-项目展示
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
        <div class="column_content" id="vc" data-paginate="1">
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
    </div>
    <div class="page sidepage" id="paginator_vc">
        <ul>
            <li class="prevpage disabled"><a href="##">上一页</a></li>
            <li class="nextpage <?php if($count['vc']<=count($vc_list)) echo 'disabled'; ?>"><a href="##">下一页</a></li>
        </ul>
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
                        <a href="{{ route('showcase.item', $showcase->id) }}"><img src="{{ Croppa::url($config_upload['showcase.logo'].$showcase->logo, 508, 320) }}"></a>
                    </div>
                    <div class="project_description">
                        <div class="project_title"><a href="{{ route('showcase.item', $showcase->id) }}">{{ $showcase->name }}</a><span class="project_like right">赞(8)</span></div>
                        <div class="project_subtitle">
                            <ul class="project_info">
                                <li><span class="project_name">领域：</span><span class="project_v">移动互联网</span></li>
                                <li><span class="project_name">联系人：</span><span class="project_v">李湘</span></li>
                                <li><span class="project_name">运营时间：</span><span class="project_v">3年</span></li>
                            </ul>
                            <div class="project_intro">
                                @if (mb_substr($showcase->summary, 0, 50, 'utf-8') != $showcase->summary)
                                {{ mb_substr($showcase->summary, 0, 50, 'utf-8') }}...
                                @else
                                {{ mb_substr($showcase->summary, 0, 50, 'utf-8') }}
                                @endif
                            </div>
                        </div>
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

    $("#paginator_vc .nextpage").click(function() {
        if ($(this).hasClass('disabled')) return;
        var id = $("#vc").data('paginate') + 1;

        $.ajax({
            type: "GET",
            url: "{{ route('vc.ajax.list') }}/" + id,
            dataType: "json",
            cache: false,
            success: function(data, textStatus) {
                if (data['code'] != 0) {
                    msg(data['message'], 'error');
                } else {
                    $("html,body").animate({scrollTop: $("#vc").offset().top - 153}, 500);

                    $("#vc").data('paginate', id);
                    $("#vc").html(data['vc_list']);

                    if (data['has_next']) {
                        $("#paginator_vc .nextpage").removeClass('disabled');
                    } else {
                        $("#paginator_vc .nextpage").addClass('disabled');
                    }
                    if (data['has_prev']) {
                        $("#paginator_vc .prevpage").removeClass('disabled');
                    } else {
                        $("#paginator_vc .prevpage").addClass('disabled');
                    }
                }
            }, error: function(data) {
                msg('网络错误，请刷新页面后重试', 'error');
            }
        });
    });

    $("#paginator_vc .prevpage").click(function() {
        if ($(this).hasClass('disabled')) return;
        var id = $("#vc").data('paginate') - 1;

        $.ajax({
            type: "GET",
            url: "{{ route('vc.ajax.list') }}/" + id,
            dataType: "json",
            cache: false,
            success: function(data, textStatus) {
                if (data['code'] != 0) {
                    msg(data['message'], 'error');
                } else {
                    $("html,body").animate({scrollTop: $("#vc").offset().top - 153}, 500);

                    $("#vc").data('paginate', id);
                    $("#vc").html(data['vc_list']);

                    if (data['has_next']) {
                        $("#paginator_vc .nextpage").removeClass('disabled');
                    } else {
                        $("#paginator_vc .nextpage").addClass('disabled');
                    }
                    if (data['has_prev']) {
                        $("#paginator_vc .prevpage").removeClass('disabled');
                    } else {
                        $("#paginator_vc .prevpage").addClass('disabled');
                    }
                }
            }, error: function(data) {
                msg('网络错误，请刷新页面后重试', 'error');
            }
        });
    });

});
</script>
@stop