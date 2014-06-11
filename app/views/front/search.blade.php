@extends('front.templates.base_page')

@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('front/css/search.css') }}">
@stop

@section('leftbar')
    <div id="b_leftbar">
        <div class="classify">
            <div class="classify_title">结果分类</div>
            <ul class="classify_list">
                <li><a href="{{ route('search') }}?q={{ $q }}&type=">全部</a></li>
                <li><a href="{{ route('search') }}?q={{ $q }}&type=news">新闻</a></li>
                <li><a href="{{ route('search') }}?q={{ $q }}&type=showcase">项目</a></li>
                <li><a href="{{ route('search') }}?q={{ $q }}&type=vc">机构</a></li>
            </ul>
        </div>
    </div>
@stop

@section('rightbar')
    <div id="b_rightbar">
        <div class="wrapper">
            <div class="column_main">
                <div class="column_main_head">
                    <div class="column_main_title">搜索结果 Search Result</div>
                </div>
            </div>
            <div class="column_content">
                @foreach ($paginator as $s)
                <div class="search_item">
                    @if ($s['type'] == 'vc')
                    <a class="search_title" href="{{ route('vc.item', $s['id']) }}">{{ $s['name'] }}</a>
                    @elseif ($s['type'] == 'showcase')
                    <a class="search_title" href="{{ route('showcase.item', $s['id']) }}">{{ $s['name'] }}</a>
                    @elseif ($s['type'] == 'news')
                    <a class="search_title" href="{{ route('news.item', $s['id']) }}">{{ $s['title'] }}</a>
                    @endif

                    <div class="search_content">{{ strip_tags(mb_substr($s['content'], 0, 200, 'utf-8'), '<br>') }}...</div>

                    @if ($s['type'] == 'vc')
                    <div class="search_info"><span class="type_name">机构</span><span class="search_time">{{ $s['datetime'] }}</span></div>
                    @elseif ($s['type'] == 'showcase')
                    <div class="search_info"><span class="type_name">项目</span><span class="search_time">{{ $s['datetime'] }}</span></div>
                    @elseif ($s['type'] == 'news')
                    <div class="search_info"><span class="type_name">新闻</span><span class="search_time">{{ $s['datetime'] }}</span></div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="page">
                <ul>
                    @if ($paginator->getCurrentPage() - 1 > 0)
                    <li class="prevpage"><a href="{{ $paginator->getUrl($paginator->getCurrentPage() - 1) }}&q={{ $q }}&type={{ $type }}">上一页</a></li>
                    @else
                    <li class="prevpage disabled"><a href="##">上一页</a></li>
                    @endif

                    @for ($i = $paginator->getCurrentPage() - 2; $i <= $paginator->getCurrentPage() + 2; $i++)
                        @if ($i > 0 && $i <= $paginator->getLastPage())
                            @if ($i == $paginator->getCurrentPage())
                            <li class="disabled"><a href="##">{{ $i }}</a></li>
                            @else
                            <li><a href="{{ $paginator->getUrl($i) }}&q={{ $q }}&type={{ $type }}">{{ $i }}</a></li>
                            @endif
                        @endif
                    @endfor

                    @if ($paginator->getCurrentPage() < $paginator->getLastPage())
                    <li class="nextpage"><a href="{{ $paginator->getUrl($paginator->getCurrentPage() + 1) }}&q={{ $q }}&type={{ $type }}">下一页</a></li>
                    @else
                    <li class="nextpage disabled"><a href="##">下一页</a></li>
                    @endif
                </ul>
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
});
</script>
@stop
