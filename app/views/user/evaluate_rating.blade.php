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
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <span class="timeline-seperator text-center"><span>评分时间：2013-06-05 18:06:03</span></span>
                            <div class="chat-body no-padding profile-message">
                                <ul>
                                    <li class="message">
                                        <img src="{{ asset('smartadmin/img/avatars/sunny.png') }}">
                                        <span class="message-text"> 
                                            <a href="javascript:void(0);" class="username">投资方：IDG 资本</a> 
                                            <p>IDG资本专注于与中国市场有关的VC/PE投资项目，在香港、北京、上海、广州、深圳等地设有办事处。<br>IDG资本重点关注消费品、连锁服务、互联网及无线应用、新媒体、教育、医疗健康、新能源、先进制造等领域的拥有一流品牌的领先企业，覆盖初创期、成长期、成熟期、Pre-IPO各个阶段，投资规模从上百万美元到上千万美元不等。</p>
                                        </span>

                                        <ul class="list-inline font-xs">
                                            <li>
                                                <span class="text-danger"><i class="fa fa-thumbs-up"></i> 赞(28)</a></span>
                                            </li>
                                            <li>
                                                <span class="text-primary">综合评分: 4.8 （沟通顺畅: 4.2 / 权益合理: 2.3 / 投资效率: 1.5 / 资源协助: 2.0）</span>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="message message-reply">
                                        <span class="message-text"> 
                                            <blockquote>
                                                <p class="text-primary">我对它的评分</p>
                                                <table>
                                                    <tr>
                                                        <td class="col-md-2 font-sm font-rating">沟通顺畅</td>
                                                        <td class="col-md-10">
                                                            <span class="irs"><span class="irs-line"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-to" style="left: 190px; display: block;">1.5</span><span class="irs-diapason" style="left: 0px; width: 200px;"></span></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-2 font-sm font-rating">权益合理</td>
                                                        <td class="col-md-10">
                                                            <span class="irs"><span class="irs-line"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-to" style="left: 285px; display: block;">3.1</span><span class="irs-diapason" style="left: 0px; width: 300px;"></span></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-2 font-sm font-rating">投资效率</td>
                                                        <td class="col-md-10">
                                                            <span class="irs"><span class="irs-line"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-to" style="left: 285px; display: block;">3.1</span><span class="irs-diapason" style="left: 0px; width: 300px;"></span></span>
                                                        </td>                                                    
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-2 font-sm font-rating">资源协助</td>
                                                        <td class="col-md-10">
                                                            <span class="irs"><span class="irs-line"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-to" style="left: 285px; display: block;">3.1</span><span class="irs-diapason" style="left: 0px; width: 300px;"></span></span>
                                                        </td>
                                                    </tr>                                                
                                                </table>
                                            </blockquote>
                                        </span>

                                        <ul class="list-inline font-xs">
                                            <li>
                                                <a href="##" class="text-primary"><i class="fa fa-cogs"></i> 修改我的评分</a>
                                            </li> 
                                            <li>
                                                <a href="##" class="text-danger"><i class="fa fa-trash-o"></i> 删除我的评分</a>
                                            </li>
                                        </ul>                                        
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
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