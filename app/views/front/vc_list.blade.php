@extends('front.templates.base')

@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('front/css/vc.css') }}">
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
    @if ($vc_list->getCurrentPage() == 1)
    <div class="column_main">
        <div class="column_main_head">
            <div class="column_main_title">推荐VC Recommend</div>
        </div>
        <div class="column_content">
            @foreach ($vc_recommend as $vc)
            <a class="vc_item" href="{{ route('vc.item', $vc->id) }}">
                <div class="vc_title">
                    {{ $vc->name }}
                    <div class="vc_commentnum">评论({{ $vc->comment_count }})</div>
                </div>
                <div class="vc_img">
                    <img src="{{ asset($config_upload['vc.logo'].$vc->logo.'-140x140') }}">
                </div>
                <ul class="vc_score">
                    <li class="vctotal">
                        <span class="vcbar_head">总分</span>
                        <span class="vcscore">{{ round($vc->score[0], 1) }}</span>
                        <span class="vc_bar" style="width:{{ $vc->score[0] * 18 }}px"></span>
                    </li>
                    @foreach ($rating_category as $category)
                    <li>
                        <span class="vcbar_head">{{ $category->title }}</span>
                        <span class="vcscore">{{ round($vc->score[$category->id], 1) }}</span>
                        <span class="vc_bar" style="width:{{ $vc->score[$category->id] * 18 }}px"></span>
                    </li>
                    @endforeach
                </ul>
                <div class="vc_description">
                    {{ $vc->summary }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
    <div class="column_main">
        <div class="column_main_head">
            <div class="column_main_title">VC排名 List of VC</div>
        </div>
        <div class="column_content">
            @foreach ($vc_list as $vc)
            <a class="vc_item" href="{{ route('vc.item', $vc->id) }}">
                <div class="vc_title">
                    {{ $vc->name }}
                    <div class="vc_commentnum">评论({{ $vc->comment_count }})</div>
                </div>
                <div class="vc_img">
                    <img src="{{ asset($config_upload['vc.logo'].$vc->logo.'-140x140') }}">
                </div>
                <ul class="vc_score">
                    <li class="vctotal">
                        <span class="vcbar_head">总分</span>
                        <span class="vcscore">{{ round($vc->score[0], 1) }}</span>
                        <span class="vc_bar" style="width:{{ $vc->score[0] * 18 }}px"></span>
                    </li>
                    @foreach ($rating_category as $category)
                    <li>
                        <span class="vcbar_head">{{ $category->title }}</span>
                        <span class="vcscore">{{ round($vc->score[$category->id], 1) }}</span>
                        <span class="vc_bar" style="width:{{ $vc->score[$category->id] * 18 }}px"></span>
                    </li>
                    @endforeach
                </ul>
                <div class="vc_description">
                    {{ $vc->summary }}
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="page">
        <ul>
            @if ($vc_list->getCurrentPage() - 1 > 0)
            <li class="prevpage"><a href="{{ $vc_list->getUrl($vc_list->getCurrentPage() - 1) }}">上一页</a></li>
            @else
            <li class="prevpage disabled"><a href="##">上一页</a></li>
            @endif

            @for ($i = $vc_list->getCurrentPage() - 2; $i <= $vc_list->getCurrentPage() + 2; $i++)
            @if ($i > 0 && $i <= $vc_list->getLastPage())
                @if ($i == $vc_list->getCurrentPage())
                    <li class="disabled"><a href="##">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $vc_list->getUrl($i) }}">{{ $i }}</a></li>
                @endif
            @endif
            @endfor

            @if ($vc_list->getCurrentPage() < $vc_list->getLastPage())
            <li class="nextpage"><a href="{{ $vc_list->getUrl($vc_list->getCurrentPage() + 1) }}">下一页</a></li>
            @else
            <li class="nextpage disabled"><a href="##">下一页</a></li>
            @endif
        </ul>
    </div>
</div>
@stop