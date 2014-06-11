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
        <div class="news_subtitle">
            @if (mb_substr($latest->summary, 0, 50, 'utf-8') != $latest->summary)
            {{ mb_substr($latest->summary, 0, 50, 'utf-8') }}...
            @else
            {{ mb_substr($latest->summary, 0, 50, 'utf-8') }}
            @endif
        </div>
        <div class="news_info">{{ $latest->datetime }}</div>
    </div>
</div>
@endforeach