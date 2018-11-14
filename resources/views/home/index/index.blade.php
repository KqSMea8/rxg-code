@extends('home.layout.layout')
@section('content')
    <style>
        .yMenuLCinList {
            padding-top: 5px;
        }
        ul.pullDownList li{
            position: relative;
        }
        .yMenuListConin{
            position: absolute;
        }
        .xsq_deal_wrapper{
            box-shadow:5px 5px 5px rgba(200,150,200,0.4)
        }
    </style>
    <div class="yHeader">
        <!-- 导航   start  -->
        <div class="yNavIndex">
            <div class="pullDown">
                <h2 class="pullDownTitle"><i class="icon-class"></i>所有商品分类</h2>
                <ul class="pullDownList">
                    @foreach($catList as $k=>$v)
                        <li class="" data-id="{{$k}}">
                            <i class=""></i>
                            <a href="{{url('goods/goodsList')}}?catId={{$v['catId']}}">{{$v['catName']}}</a>
                            <span></span>
                        </li>
                    @endforeach
                </ul>
                <!-- 下拉详细列表具体分类 -->
                <div class="yMenuListCon" style="margin-top: 6px">
                    @foreach($catList as $k=>$v)
                        <div class="yMenuListConin">
                            <div class="yMenuLCinList">
                                <h3><a href="javascript:;" class="yListName"></a><a href="" class="yListMore">更多 ></a></h3>
                                <p></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <ul class="yMenuIndex">
                <li><a href="{{url('/')}}">任性购首页</a></li>
                <li><a href="{{url('shop/shops')}}">店铺中心 </a></li>
                <li><a href="{{url('consult/consult')}}">商城快讯</a></li>
                {{--<li><a href="{{url('collect/favoriteGoods')}}">我的收藏</a></li>--}}
                <li><a href="{{url('sales/salesList')}}">客户服务</a></li>
                <li><a href="{{url('feedback/feedback')}}">意见反馈</a></li>
                <!--<li><a href="{{url('merchant/register')}}">商家入驻</a></li>-->
            </ul>
        </div>
        <!-- 导航   end  -->
    </div>
    <!--  顶部    end-->

    <!-- banner  -->
    <div class="yBanner">
        <div class="yBannerList" style="background: linear-gradient(#ee4644, rgba(200,50,0,0.3))">
            <div class="yBannerListIn" style="width: 1224px;padding-left: 23px;">
                <!--首页轮播图-->
                <div class="layui-carousel" id="test1">
                    <div carousel-item>
                        <div>
                            <a href="">
                                <img class="ymainBanner"
                                     src="{{URL::asset('uploads/solideshow/2bf699a2fe833fcf806859955c55957b.jpg')}}"
                                     width="100%" height="500">
                            </a>
                        </div>
                        <div>
                            <a href="">
                                <img class="ymainBanner"
                                     src="{{URL::asset('uploads/solideshow/4cb6b4fce0ba9e8e95264fec9803772e.jpg')}}"
                                     width="100%" height="500">
                            </a>
                        </div>
                        <div>
                            <a href="">
                                <img class="ymainBanner"
                                     src="{{URL::asset('uploads/solideshow/4dd5e2cca8b31d6f13766905d8efcddf.jpg')}}"
                                     width="100%" height="500">
                            </a>
                        </div>
                    </div>
                </div>
                <!--轮播图结束-->

                <!--广告位-->
                <div class="yBannerListInRight">
                    @if($data[0]->time>$data[0]->stime && $data[0]->time<$data[0]->otime)
                        @foreach($data as $v)
                            @if($v->place==1)
                                <img src="{{URL::asset($v->img)}}" width="190" height="250"/>
                            @elseif($v->place==2)
                                <td width="190" height="250">{{$v->details}}</td>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- banner end -->
    <section id="s" style="background:rgba(0,0,0,0.05)">
        <div style="height: 30px"></div>
        <div class="center">
            <!--活动促销-->
            <div class="pc-center-he">
                <div class="pc-box-he clearfix" style="background:rgba(0,0,0,0.00);border-bottom: 3px solid red;margin-bottom: 5px">
                    <div class="fl" style="font-family: 幼圆;font-size: 26px;color: red;line-height: 30px;font-weight: bold">
                        <img src="{{URL::asset('img/活动.png')}}" height="30"> 活动促销
                    </div>
                    <div class="time-item fr">
                        <strong id="hour_show">0时</strong>
                        <strong id="minute_show">00分</strong>
                        <strong id="second_show">00秒</strong>
                        <em style="color:#0d3625">后结束抢购</em>
                    </div>
                </div>
                @foreach($activeGoodsList as $k=>$v)
                <div class="flashSaleDeals" style="height: 300px;">
                    <div class="v_cont" style="width:9648px;overflow: hidden;height: 300px;">
                        <ul class="flder">
                                <li index="0" style="height: 300px;">
                                    @foreach($v as $key=>$val)
                                        <div class="xsq_deal_wrapper" style="margin:0 2px;height: 265px;">
                                            <a class="saleDeal"
                                               href="{{url('goods/detail')}}?goodsId={{$val['goodsId']}}" style="padding-top: 20px;width: 190px;height: 245px;">
                                                <div class="dealCon" style="margin: 0 auto">
                                                    <img class="dealImg" src="{{URL::asset($val['goodsImg'])}}" alt="">
                                                    <div class="stock">
                                                        <div class="xsqMask"></div>
                                                        <span class="stockWord">
                                                            <i class="stocknumber">还剩{{$val['goodsStock']}}</i>
                                                            {{$val['activityName']}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="title_new">
                                                    <p class="word" title="{{$val['goodsName']}}">
                                                        {{$val['goodsName']}}
                                                    </p>
                                                </div>
                                                <div class="dealInfo">
                                                    <span class="price">¥<em>{{$val['favourable']}}</em></span>
                                                    <span class="price"
                                                          style="padding-left: 20px;font-size: 6px;text-decoration: line-through">¥{{$val['shopPrice']}}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
            <!--热销商品-->
            <div class="pc-center-he">
                <div class="pc-box-he clearfix" style="background:rgba(0,0,0,0.00);border-bottom: 3px solid red;margin-bottom: 5px">
                    <div class="fl" style="font-family: 幼圆;font-size: 24px;color: red;line-height: 30px;font-weight: bold">
                        <img src="{{URL::asset('img/热销.png')}}" height="30"> 热销商品
                    </div>
                </div>
                @foreach($hotGoodsList as $k=>$v)
                    <div class="flashSaleDeals" style="height: 285px;">
                        <div class="v_cont" style="width:9648px;overflow: hidden;height: 300px;">
                            <ul class="flder">
                                <li index="0"  style="height: 285px;">
                                    @foreach($v as $key=>$val)
                                        <div class="xsq_deal_wrapper" style="margin:0 2px;height: 265px;">
                                            <a class="saleDeal"
                                               href="{{url('goods/detail')}}?goodsId={{$val['goodsId']}}" style="padding-top: 20px;width: 190px;height: 245px;">
                                                <div class="dealCon" style="margin: 0 auto">
                                                    <img class="dealImg" src="{{URL::asset($val['goodsImg'])}}" alt="">
                                                    <div class="stock">
                                                        <div class="xsqMask"></div>
                                                        <span class="stockWord"><i
                                                                    class="stocknumber">还剩{{$val['goodsStock']}}</i> {{$val['goodsDesc']}}</span>
                                                    </div>
                                                </div>
                                                <div class="title_new">
                                                    <p class="word" title="{{$val['goodsName']}}"><span
                                                                class="baoyouText">[{{(intval($val['freight'])*100===0)?'包邮':'邮费'.$val['freight']}}
                                                            ]</span>{{$val['goodsName']}}</p>
                                                </div>
                                                <div class="dealInfo">
                                                    <span class="price">¥<em>{{$val['shopPrice']}}</em></span>
                                                    <span class="price"
                                                          style="padding-left: 20px;font-size: 6px;text-decoration: line-through">¥{{$val['marketPrice']}}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--推荐商品-->
            <div class="pc-center-he">
                <div class="pc-box-he clearfix" style="background:rgba(0,0,0,0.00);border-bottom: 3px solid red;margin-bottom: 5px">
                    <div class="fl" style="font-family: 幼圆;font-size: 26px;color: red;line-height: 30px;font-weight: bold">
                        <img src="{{URL::asset('img/推荐.png')}}" height="30"> 推荐商品
                    </div>
                </div>
                @foreach($recomGoodsList as $k=>$v)
                    <div class="flashSaleDeals" style="height: 300px;">
                        <div class="v_cont" style="width:9648px;overflow: hidden;height: 300px;">
                            <ul class="flder">
                                <li index="0" style="height: 300px;">
                                    @foreach($v as $key=>$val)
                                        <div class="xsq_deal_wrapper" style="margin:0 2px;height: 265px;">
                                            <a class="saleDeal" href="{{url('goods/detail')}}?goodsId={{$val['goodsId']}}" style="padding-top: 20px;width: 190px;height: 245px;">
                                                <div class="dealCon" style="margin: 0 auto">
                                                    <img class="dealImg" src="{{URL::asset($val['goodsImg'])}}" alt="">
                                                    <div class="stock">
                                                        <div class="xsqMask"></div>
                                                        <span class="stockWord"><i
                                                                    class="stocknumber">还剩{{$val['goodsStock']}}</i> {{$val['goodsDesc']}}</span>
                                                    </div>
                                                </div>
                                                <div class="title_new">
                                                    <p class="word" title="{{$val['goodsName']}}"><span
                                                                class="baoyouText">[{{(intval($val['freight'])*100===0)?'包邮':'邮费'.$val['freight']}}
                                                            ]</span>{{$val['goodsName']}}</p>
                                                </div>
                                                <div class="dealInfo">
                                                    <span class="price">¥<em>{{$val['shopPrice']}}</em></span>
                                                    <span class="price"
                                                          style="padding-left: 20px;font-size: 6px;text-decoration: line-through">¥{{$val['marketPrice']}}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(!empty($userLove))
            <!--猜你喜欢-->
            <div class="pc-center-he">
                <div class="pc-box-he clearfix" style="background:rgba(0,0,0,0.00);border-bottom: 3px solid red;margin-bottom: 5px">
                    <div class="fl" style="font-family: 幼圆;font-size: 26px;color: red;line-height: 30px;font-weight: bold">
                        <img src="{{URL::asset('img/喜欢.png')}}" height="30"> 猜你喜欢
                    </div>
                </div>
                <div class="flashSaleDeals" style="height: 300px;">
                    <div class="v_cont1" style="width:9648px;overflow: hidden;height: 300px;">
                        <ul class="flder">
                            @foreach($userLove as $k=>$v)
                                <li index="{{$k}}" style="height: 300px;">
                                    @foreach($v as $key=>$val)
                                        <div class="xsq_deal_wrapper" style="margin:0 2px;height: 265px;">
                                            <a class="saleDeal"
                                               href="{{url('goods/detail')}}?goodsId={{$val['goodsId']}}" style="padding-top: 20px;width: 190px;height: 245px;">
                                                <div class="dealCon" style="margin: 0 auto">
                                                    <img class="dealImg" src="{{URL::asset($val['goodsImg'])}}" alt="">
                                                    <div class="stock">
                                                        <div class="xsqMask"></div>
                                                        <span class="stockWord">
                                                            <i class="stocknumber">还剩{{$val['goodsStock']}}</i>
                                                           123
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="title_new">
                                                    <p class="word" title="{{$val['goodsName']}}">
                                                        {{$val['goodsName']}}
                                                    </p>
                                                </div>
                                                <div class="dealInfo">
                                                    <span class="price">¥<em>123</em></span>
                                                    <span class="price"
                                                          style="padding-left: 20px;font-size: 6px;text-decoration: line-through">¥{{$val['shopPrice']}}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                        <a href="javascript:;" class="zuo trigger"></a>
                        <a href="javascript:;" class="you trigger"></a>
                    </div>
                </div>
            </div>
            <!--猜你喜欢-->
            @endif
        </div>
    </section>
    <script type="text/javascript">
        layui.use('carousel', function () {
            var carousel = layui.carousel;
            //建造实例
            carousel.render({
                elem: '#test1'
                , width: '100%' //设置容器宽度
                , height: '500px'
                , arrow: 'none' //始终显示箭头
                ,
            });
        });
        $("div.xsq_deal_wrapper").hover(function () {
            $(this).css('border',"2px solid rgb(0,0,255,0.3)");
            $(this).children("a").css("width",'186px');
            $(this).children("a").css("height",'241px');
            $(this).css('width',"191px");
            $(this).css('height',"261px");
        },function () {
            $(this).css('border',"");
            $(this).css('width',"195px");
            $(this).css('height',"265px");
            $(this).children("a").css("width",'190px');
            $(this).children("a").css("height",'245px');
        });
    </script>
@endsection