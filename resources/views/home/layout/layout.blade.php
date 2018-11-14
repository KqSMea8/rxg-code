<?php
use Illuminate\Support\Facades\Request;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
    <meta name="renderer" content="webkit">
    <title>任性购商城-换一种方式购物</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/home.css')}}">
    <!-- 我的订单css -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/member.css')}}">
    <script type="text/javascript" src="{{URL::asset('home/js/modernizr-custom-v2.7.1.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('home/js/jquery.SuperSlide.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('home/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('home/js/index.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('home/js/jquery-1.8.3.min.js')}}"></script>
    <!-- 确认订单 -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/car/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/car/home.css')}}">
    <!-- 商品详情页面样式 -->
    <link rel="stylesheet" href="{{URL::asset('home/css/detail1.css')}}">
    <link rel="stylesheet" href="{{URL::asset('home/css/detail2.css')}}">
    <link rel="stylesheet" href="{{URL::asset('home/css/detail3.css')}}">
    <link rel="stylesheet" href="{{URL::asset('home/css/detail4.css')}}">
    <link rel="stylesheet" href="{{URL::asset('home/css/detail5.css')}}">
    <link rel="stylesheet" href="{{URL::asset('home/css/jquery-labelauty.css')}}">
    
    <!-- 分页样式 -->
    <script type="text/javascript" src="{{URL::asset('home/js/jquery.SuperSlide.js')}}"></script>
    <script src="{{URL::asset('layer/layer.js')}}"></script>
    <script src="{{URL::asset('layui/css/layui.css')}}"></script>
    <script src="{{URL::asset('layui/layui.js')}}"></script>
    <style type="text/css">
        #pull_right {
            text-align: center;
        }

        .pull-right {
            /*float: left!important;*/
        }

        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }

        .pagination > li {
            display: inline;
        }

        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #2a6496;
            background-color: #eee;
            border-color: #ddd;
        }

        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca;
            border-color: #428bca;
        }

        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }

        .clear {
            clear: both;
        }
        #service{
            position: fixed;
            width: 54px;
            right: 0;
            bottom: 50px;
            z-index: 10;
        }
    </style>

    <!-- 支付方式 -->
    <script type="text/javascript" src="{{URL::asset('home/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('home/js/index.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('home/js/modernizr-custom-v2.7.1.min.js')}}"></script>
    <!-- 收藏 -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/member.css')}}">
    <script type="text/javascript" src="{{URL::asset('home/js/jquery.SuperSlide.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('home/js/jquery-labelauty.js')}}"></script>


    <script src="{{URL::asset('layer/layer.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            if("{{Request::path()}}"==='/' || "{{Request::path()}}"==="index" || "{{Request::path()}}"==="index/index"){
            }else{
                $(".yMenuListCon").hide();
                $("ul[class='pullDownList']").hide();
                $("h2[class='pullDownTitle']").on('mouseenter',function () {
                    $("ul[class='pullDownList']").show();
                    // console.log(1);
                });
                $("ul[class='pullDownList']").on("mouseleave",function () {
                    $(this).hide();
                });
                $("div.yMenuListConin").on('mouseenter',function () {
                    $("ul[class='pullDownList']").show();
                });
                $("div.yMenuListConin").on('mouseleave',function () {
                    $("ul[class='pullDownList']").hide();
                })
            }
        });
        var intDiff = parseInt("{{strtotime(explode(' ',date("Y-m-d H:i:s",time()))[0].' 23:59:59')-time()}}");//倒计时总秒数量

        function timer(intDiff) {
            window.setInterval(function () {
                var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;//时间默认值
                if (intDiff > 0) {
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                $('#day_show').html(day + "天");
                $('#hour_show').html('<s id="h"></s>' + hour + '时');
                $('#minute_show').html('<s></s>' + minute + '分');
                $('#second_show').html('<s></s>' + second + '秒');
                intDiff--;
            }, 1000);
        }

        $(function () {
            timer(intDiff);
        });//倒计时结束

        $(function () {
            /*======右按钮======*/
            $(".you").click(function () {
                nextscroll();
            });

            function nextscroll() {
                var vcon = $(".v_cont1");
                var offset = ($(".v_cont1 li").width()) * -1;
                vcon.stop().animate({marginLeft: offset}, "slow", function () {
                    var firstItem = $(".v_cont1 ul li").first();
                    vcon.find(".flder").append(firstItem);
                    $(this).css("margin-left", "0px");
                });
            };
            /*========左按钮=========*/
            $(".zuo").click(function () {
                var vcon = $(".v_cont1");
                var offset = ($(".v_cont1 li").width() * -1);
                var lastItem = $(".v_cont1 ul li").last();
                vcon.find(".flder").prepend(lastItem);
                vcon.css("margin-left", offset);
                vcon.animate({marginLeft: "0px"}, "slow")
            });
        });
    </script>
    <!--layer css样式-->
    <link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}">
</head>
<body>
<header id="pc-header">
    <div class="pc-header-nav">
        <div class="pc-header-con">
            <div class="fl pc-header-link">
                <i class="layui-icon layui-icon-tree"></i>
                @if(session()->get('userId'))
                    您好！<a href="">{{session()->get('username')}}</a>，
                    <a href="{{url('login/loginOut')}}">[退出]</a>欢迎来任性购
                @else
                    <a href="{{url('login/login')}}">亲，请登录</a>
                    <a href="{{url('login/register')}}"> 免费注册</a>
                @endif
            </div>
            <div class="fr pc-header-list top-nav">
                <ul>
                    <li>
                        <div class="nav">
                            {{--<i class="pc-top-icon"></i>--}}
                            <a href="{{url('order/index')}}">我的订单</a>
                        </div>
                        <div class="con">
                            <dl>
                                <dt><a href="">批发进货</a></dt>
                                <dd><a href="">已买到货品</a></dd>
                                <dd><a href="">优惠券</a></dd>
                                <dd><a href="">店铺动态</a></dd>
                            </dl>
                        </div>
                    </li>
                    <li>
                        <div class="nav">
                            <!-- <i class="pc-top-icon"></i> -->
                            <a href="{{url('collect/favoriteGoods')}}">我的收藏</a>
                        </div>
                        <div class="con">
                            <dl>
                                <dt><a href="{{url('consult/evaluate')}}">评价</a></dt>
                                <dd><a href="{{url('consult/classify')}}">所有分类</a></dd>
                                <dd><a href="{{url('coupon/coupon')}}">优惠券</a></dd>
                                <dd><a href="">店铺动态</a></dd>
                            </dl>
                        </div>
                    </li>
                    <li><a href="{{url('shop/goods')}}">我的任性购</a></li>
                    <li><a href="{{url('goods/userHistory')}}">我的足迹</a></li>
                    <li><a href="{{url('user/userList')}}">用户中心</a></li>
                    <li><a href="{{url('sales/salesList')}}">客户服务</a></li>
                    <li><a href="{{url('feedback/feedback')}}">意见反馈</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="pc-header-logo clearfix">
        <div class="pc-fl-logo fl" style="width: 200px;height:90px">
            <a href="{{url('/')}}">
                <img src="{{URL::asset('img/logo.png')}}" alt="">
            </a>
        </div>
        <div class="head-form fl">
            <form class="clearfix">
                <input class="search-text" accesskey="" id="esKeyword" autocomplete="off" placeholder="大家都在搜：iphone-11" type="text" value="{{empty($esKeyword)?'':$esKeyword}}">
                <button class="button" id="elasticSearch">搜索</button>
            </form>

        </div>
     
        <div class="fr pc-head-car">
            <i class="icon-car"></i>
            <a href="{{url('cart/cart')}}">我的购物车</a>
            <em>{{(session()->get('cartNum'))?session()->get('cartNum'):0}}</em>
        </div>
    </div>
@yield('content')
<!--  顶部    start-->
<a id='service' style="float:right" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1105385285&site=qq&menu=yes"><img style="height:100px" border="0" src="http://wpa.qq.com/pa?p=2:1105385285:53" alt="任性购客服" title="任性购客服"/></a>
</header>
<footer>
    <div class="pc-footer-top">
        <div class="center">
            <ul class="clearfix">
                <li style="width:20%">
                <center>
                    <span><b>关于我们</b></span>
                    <a href="{{url('index/Abouts')}}">关于我们</a>
                    <a href="{{url('index/Careers')}}">诚聘英才</a>
                    <a href="{{url('index/service')}}">用户服务协议</a>
                    <a href="{{url('index/sites')}}">网站服务条款</a>
                    <a href="{{url('index/About')}}">联系我们</a>
                </center>
                </li>
                <li class="lw" style="width:20%">
                <center>
                    <span><b>消费者保障</b></span>
                    <a href="#">人工验货</a>
                    <a href="#">退货退款政策</a>
                    <a href="#">运费补贴卡</a>
                    <a href="#">无忧售后</a>
                    <a href="#">先行赔付</a>
                </center>
                </li>
                <li class="lw" style="width:20%;">
                <center>
                    <span><b>商务合作</b></span>
                    <a href="#">人工验货</a>
                    <a href="#">退货退款政策</a>
                    <a href="#">运费补贴卡</a>
                    <a href="#">无忧售后</a>
                    <a href="#">先行赔付</a>
                </center>
                </li>
                <li class="lss" >
                    <span>下载手机版</span>
                    <div class="clearfix lss-pa">
                        <div class="fl lss-img"><img src="{{URL::asset('img/phoneAppCode.png')}}" alt=""></div>
                        <div class="fl" style="padding-left:20px">
                            <h4>扫描下载任性购APP</h4>
                            <p>把优惠握在手心</p>
                            <P>把潮流带在身边</P>
                            <P></P>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="pc-footer-lin">
            <div class="center">
                <p>友情链接：
                    卡宝宝信用卡
                    梦芭莎网上购物
                    手游交易平台
                    法律咨询
                    深圳地图
                    P2P网贷导航
                    名鞋库
                    万表网
                    叮当音乐网
                    114票务网
                    儿歌视频大全
                </p>
                <p>
                    京ICP证1900075号 京ICP备20051110号-5 京公网安备110104734773474323 统一社会信用代码 91113443434371298269B
                    食品流通许可证SP1101435445645645640352397
                </p>
                <p style="padding-bottom:30px">版物经营许可证 新出发京零字第朝160018号 Copyright©2011-2015 版权所有 ZHE800.COM </p>
            </div>
        </div>
    </div>
</footer>
<script>
    $("#elasticSearch").on('click',function (e) {
        e.preventDefault();
        var esKeyword = $("#esKeyword").val();
        if(esKeyword===''){
            layer.msg('搜索关键词不能为空哦~',{
                time:2000,
                icon:5
            })
        }else{
            location.href=encodeURI("{{url('goods/goodsList')}}?esKeyword="+esKeyword);
        }
    });
    //hover 触发两个事件，鼠标移上去和移走
    //mousehover 只触发移上去事件

    $("ul[class='pullDownList'] li").hover(function () {
        var k = $(this).attr('data-id');
        var catList = @json($catList);
        var str = '';
        $(catList[k]['child']).each(function (ke, v) {
            var str1 = '';
            $(v.child).each(function (key, val) {
                str1 += '<a href="{{url("goods/goodsList")}}?catId='+val.catId+'" class="ecolor610">' + val.catName + '</a>';
            });
            str += '\
                <div class="yMenuLCinList">\
                        <h3><a href="{{url('goods/goodsList')}}?catId='+v.catId+'" class="yListName">' + v.catName + '</a><a href="" class="yListMore">更多 ></a></h3>\
                <p>\
                <a href="" class="ecolor610">' + str1 + '</a>\
                    </p>\
                    </div>\
                ';
        });
        $('.yMenuListConin').html(str);
        $(this).addClass("hover").siblings().removeClass("hover");
        $(this).find("li .nav a").addClass("hover");
        $(this).find(".con").show();
    }, function () {
        $(this).prop('class', '');
        //$(this).css("background-color","#f5f5f5");
        $(this).find(".con").hide();
        //$(this).find(".nav a").removeClass("hover");
        $(this).removeClass("hover");
        $(this).find(".nav a").removeClass("hover");
    })
</script>
</body>
</html>