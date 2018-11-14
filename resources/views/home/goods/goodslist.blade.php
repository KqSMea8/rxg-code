@extends('home.layout.layout')
@section('content')

    <!-- 购物车 -->
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
    </header>
    <div class="pc-center-he" style="margin:0 auto">
        <div class="pc-box-he clearfix" style="background:rgba(0,0,0,0.00);border-bottom: 3px solid red;margin-bottom: 5px;margin:0 auto">
            <div class="fl" style="font-family: 幼圆;font-size: 26px;color: red;line-height: 30px;font-weight: bold">
                {{$titleTips}}
            </div>
        </div>
        @foreach($data as $k=>$v)
            <div class="flashSaleDeals" style="height: 300px;margin:0 auto">
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
                                                    {{$val['goodsName']}}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="title_new">
                                            <p class="word" title="{{$val['goodsName']}}">
                                                {{$val['goodsName']}}
                                            </p>
                                        </div>
                                        <div class="dealInfo">
                                            <span class="price">¥<em>{{$val['shopPrice']}}</em></span>
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
        <div class="pc-box-he clearfix" style="background:rgba(0,0,0,0.00);margin:0 auto">
            <div class="fr" style="font-family: 幼圆;color: red;line-height: 30px;font-weight: bold">
                {{$pagination}}
            </div>
        </div>
    </div>
@endsection