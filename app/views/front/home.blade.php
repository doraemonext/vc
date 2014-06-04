@extends('front.templates.base')

@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('front/css/index.css') }}">
@stop

@section('slider')
<div id="ad_slider">
    <div id="ad_slider_container">
        <div id="carousel-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-generic" data-slide-to="1"></li>
                <li data-target="#carousel-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" id="ad_slider_imgs">
                <div class="item active">
                    <a href="" style="background-image:url({{ asset('front/images/ad_slider1.png') }})"></a>
                </div>
                <div class="item">
                    <a href="" style="background-image:url({{ asset('front/images/ad_slider2.png') }})"></a>
                </div>
                <div class="item">
                    <a href="" style="background-image:url({{ asset('front/images/ad_slider3.png') }})"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <span class="ad_data">已入驻VC {{ $count['vc'] }}</span>
        <span class="ad_data">已入驻联合创始人 {{ $count['user'] }}</span>
        <span class="ad_data">已有评论 33,233,233,233</span>
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
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="{{ asset('front/images/project_slider1.png') }}" alt="">
                            <div class="carousel-caption">
                                <div class="project_title"><a href="">电子温度计nest横空出世 小编随记者深入访问耶鲁大学ever团队</a></div>
                                <div class="project_subtitle">nest可以穿戴，便于携带，我们的团队励志创造新一代电子携带产品的工业革命……</div>
                                <div class="project_info">小编a 20:10 05/10</div>
                            </div>
                        </div>
                        <div class="item">
                            <img src="{{ asset('front/images/project_slider2.png') }}" alt="">
                            <div class="carousel-caption">
                                <div class="project_title"><a href="">第二个项目的标题222222222222</a></div>
                                <div class="project_subtitle">第二个项目的描述2222222222222</div>
                                <div class="project_info">小编a 20:10 05/10</div>
                            </div>
                        </div>
                        <div class="item">
                            <img src="{{ asset('front/images/project_slider3.png') }}" alt="">
                            <div class="carousel-caption">
                                <div class="project_title"><a href="">第三个项目的标题3333333333</a></div>
                                <div class="project_subtitle">第三个项目的描述3333333333333</div>
                                <div class="project_info">小编a 20:10 05/10</div>
                            </div>
                        </div>
                        <div class="item">
                            <img src="{{ asset('front/images/project_slider4.png') }}" alt="">
                            <div class="carousel-caption">
                                <div class="project_title"><a href="">第四个项目的标题44444444444</a></div>
                                <div class="project_subtitle">第四个项目的描述4444444444444</div>
                                <div class="project_info">小编a 20:10 05/10</div>
                            </div>
                        </div>
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
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
            <div class="news_item">
                <div class="news_left">
                    <img src="{{ asset('front/images/news_img_main.png') }}">
                    <a class="news_forward" title="回应人数" href="">
                        <span class="icon icon_forward"></span>
                    233
                    </a>
                </div>
                <div class="news_right">
                    <div class="news_title"><a href="">谈谈唱吧并购线下KTV的逻辑启示：并购一家线下量贩式连锁KTV，唱吧这一步迈得...</a></div>
                    <div class="news_subtitle">唱吧将并购一家线下量贩式连锁KTV，这一步迈得漂亮。</div>
                    <div class="news_info">小编a  20:10  05/10</div>
                </div>
            </div>
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
            <div class="hotnews_item">
                <div class="hotnews_img">
                    <img src="{{ asset('front/images/news_img.png') }}">
                </div>
                <div class="hotnews_title">
                    <a href="">微信封杀人工智能机器人“微软小冰”，两家公司各执一词</a>
                </div>
            </div>
            <div class="hotnews_item">
                <div class="hotnews_img">
                    <img src="{{ asset('front/images/news_img.png') }}">
                </div>
                <div class="hotnews_title">
                    <a href="">微信封杀人工智能机器人“微软小冰”，两家公司各执一词</a>
                </div>
            </div>
            <div class="hotnews_item">
                <div class="hotnews_img">
                    <img src="{{ asset('front/images/news_img.png') }}">
                </div>
                <div class="hotnews_title">
                    <a href="">微信封杀人工智能机器人“微软小冰”，两家公司各执一词</a>
                </div>
            </div>
            <div class="hotnews_item">
                <div class="hotnews_img">
                    <img src="{{ asset('front/images/news_img.png') }}">
                </div>
                <div class="hotnews_title">
                    <a href="">微信封杀人工智能机器人“微软小冰”，两家公司各执一词</a>
                </div>
            </div>
            <div class="hotnews_item">
                <div class="hotnews_img">
                    <img src="{{ asset('front/images/news_img.png') }}">
                </div>
                <div class="hotnews_title">
                    <a href="">微信封杀人工智能机器人“微软小冰”，两家公司各执一词</a>
                </div>
            </div>
            <div class="hotnews_item">
                <div class="hotnews_img">
                    <img src="{{ asset('front/images/news_img.png') }}">
                </div>
                <div class="hotnews_title">
                    <a href="">微信封杀人工智能机器人“微软小冰”，两家公司各执一词</a>
                </div>
            </div>
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
