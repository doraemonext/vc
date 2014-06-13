@foreach ($vc_list as $vc)
<div class="investor_item">
    <a class="item_investor" href="{{ route('vc.item', $vc->id) }}">
        <div class="investor_head">
            <span class="investor_name">{{ $vc->name }}</span>
            <span class="investor_update">第 {{ $vc->rank }} 名</span>
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