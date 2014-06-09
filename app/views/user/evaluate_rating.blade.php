@extends('user.templates.base')

@section('breadcrumb')
    <li>我的评价</li>
    <li>我的评分列表</li>
@stop

@section('content')
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-file-o"></i> 我的评价 <span>&gt; 我的评分列表 </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                @if (count($rating) === 0)
                <div class="alert alert-info alert-block">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><i class="fa-fw fa fa-info"></i>您尚未对任何投资方作出评分！</h4>
                </div>
                @else                
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            @foreach ($rating as $r)
                            <span class="timeline-seperator text-center"><span>评分时间：{{ $r['datetime'] }}</span></span>
                            <div class="chat-body no-padding profile-message">
                                <ul>
                                    <li class="message">
                                        <img src="{{ Croppa::url($config_upload['vc.logo'].$r['vc']['logo'], 54, 50) }}">
                                        <span class="message-text"> 
                                            <a href="{{ route('vc.item', $r['vc']['id']) }}" class="username">投资方：{{ $r['vc']['name'] }}</a> 
                                            <p>{{ $r['vc']['summary'] }}</p>
                                        </span>

                                        <ul class="list-inline font-xs">
                                            <li>
                                                <span class="text-danger"><i class="fa fa-thumbs-up"></i> 赞({{ $r['vc']['vote'] }})</a></span>
                                            </li>
                                            <li>
                                                <span class="text-primary">综合评分: <span class="badge bg-color-greenLight">{{ round($r['vc']['rating'], 1) }}</span>
                                                    （
                                                    @foreach ($category as $index => $c)
                                                    {{ $c['title'] }}: {{ round($r[$c['id']]['score'], 1) }}
                                                    @if ($index < count($category) - 1)
                                                    /
                                                    @endif
                                                    @endforeach
                                                    ）
                                                </span>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="message message-reply">
                                        <span class="message-text"> 
                                            <blockquote>
                                                <p class="text-primary">我对它的评分</p>
                                                <table>
                                                    @foreach ($category as $c)
                                                    <tr>
                                                        <td class="col-md-2 font-sm font-rating">{{ $c['title'] }}</td>
                                                        <td class="col-md-10">
                                                            <span class="irs"><span class="irs-line"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-to" style="left: {{ round($r[$c['id']]['score'] * 81 - 10) }}px; display: block;">{{ round($r[$c['id']]['score'], 1) }}</span><span class="irs-diapason" style="left: 0px; width: {{ round($r[$c['id']]['score'] * 81) }}px;"></span></span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </blockquote>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('custom_js')
    <script type="text/javascript">
    $(document).ready(function() {
        pageSetUp();
    });
    </script>
@stop