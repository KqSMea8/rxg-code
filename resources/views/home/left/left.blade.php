@extends('home.layout.layout')
@section('content')
    <style>
        div.member-lists dl dd{
            margin: 0;
        }
    </style>
    <div class="yHeader">
        <!-- 导航   start  -->
        <div class="yNavIndex">
            <div class="pullDown">
                <h2 class="pullDownTitle"><i class="icon-class"></i>所有商品分类</h2>
                <ul class="pullDownList" style="display: none">
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
            </ul>
        </div>
        <!-- 导航   end  -->
    </div>

    </header>

    <div class="containers center">

    </div>
    <section id="member">
        <div class="member-center clearfix">
            <div class="member-left fl">
                <div class="member-apart clearfix">
                     <div class="fl" style="float:  none;margin: 0 auto;width:  60px;">
                         <a href="#">
                            <img src="http://123.206.83.112/home/img/mem.png" style="width: 60px;height: 60px;border:  1px solid #ddd;border-radius:  50%;">
                         </a>
                     </div>
                    <div class="fl" style="font-size: 12px;/* float: right; */margin-top: 5px;width: 100%;text-align:  center;/* margin-bottom:  5px; */">
                        <p>用户名：<a href="#">{{session()->get('username')}}</a></p>
                    </div>
                    </div>
                <div class="member-lists">
                    <dl>
                        <dt><b>我的商城</b></dt>
                        <dd><a href="{{url('order/index')}}">我的订单</a></dd>
                        <dd><a href="{{url('collect/favoriteGoods')}}">我的收藏</a></dd>
                        <dd><a href="{{url('user/user')}}">账户安全</a></dd>
                        <dd><a href="{{url('address/addressAdd')}}">地址管理</a></dd>
                    </dl>
                    <dl>
                        <dt><b>客户服务</b></dt>
                        <dd><a href="{{url('sales/salesList')}}">退货/退款记录</a></dd>
                    </dl>
                    <dl>
                        <dt><b>我的消息</b></dt>
                        <dd><a href="#">商城快讯</a></dd>
                    </dl>
                </div>
            </div>
            @yield('left')
        </div>
    </section>
@endsection