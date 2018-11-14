@extends('home.layout.layout')
@section('content')
<style>
#sku dl dd ul { list-style-type: none;}
#sku dl dd ul li { display: inline-block;}
#sku dl dd ul li { margin: 10px 0;}
#sku dl dd ul li { padding: 0}

input.labelauty { font: 12px "Microsoft Yahei";}
.dowebok label{
    text-align: center;
}
</style>


    <!-- 购物车 -->
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
            <!--<li><a href="{{url('merchant/register')}}">商家入驻</a></li>-->
            </ul>
        </div>
        <!-- 导航   end  -->
    </div>
    </header>
    <!--主要模板内容 开始-->
    <div class="home_content">
        <div class="bigweb">
            <section class="breadcrumb">
                <span>您当前的位置：</span> <a href="/">首页</a> >
                {{$goodsInfo->goodsName}}
            </section>
            <!--图片放大镜-->
            <section class="goods_base">
                <section class="goods_zoom">
                    <div class="pic_show" style="width:435px;height:435px;position:relative;padding-bottom:5px;">
                        <img id="picShow" rel="" src="{{URL::asset($goodsInfo->goodsImg)}}" width="400"/>
                    </div>

                    <ul id="goodsPhotoList" class="pic_thumb">
                        <li>
                            <a href="javascript:void(0);" thumbimg="{{URL::asset($goodsInfo->goodsImg)}}" sourceimg="{{URL::asset($goodsInfo->goodsImg)}}">
                                <img src='{{URL::asset($goodsInfo->goodsImg)}}' width="60px" height="60px" />
                            </a>
                        </li>
                        @foreach($goodsThumb as $k=>$v)
                        <li>
                            <a href="javascript:void(0);" thumbimg="{{URL::asset($v->gallaryImg)}}" sourceimg="{{URL::asset($v->gallaryImg)}}">
                                <img src='{{URL::asset($v->gallaryImg)}}' width="60px" height="60px" />
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </section>
                <!--图片放大镜-->
                <section class="goods_info">
                    <h1 class="goods_info_title"> {{$goodsInfo->goodsName}}</h1>
                    <div class="goods_info_num">商品编号：<span id="data_goodsNo">{{$goodsInfo->goodsId}}</span></div>
                    <!--基本信息区域-->
                    <ul class="goods_ul">
                        <li>
                        </li>
                        <!--抢购活动,引入 "_products_time"模板-->
                        <!--团购活动,引入 "_products_groupon"模板-->
                        <!--普通正常-->
                        <li><em class="price">销售价：￥<span id="data_sellPrice">{{$goodsInfo->shopPrice}}</span></em></li>

                        <li>市场价：￥
                            <del id="data_marketPrice">{{$goodsInfo->marketPrice}}</del>
                        </li>
                        <li>
                            库存：现货 <span id="data_storeNums">{{$goodsInfo->goodsStock}} </span>
                            <span class="favorite" id="favorite" onclick="addFavorite({{$goodsInfo->goodsId}})">
                            <i class="fa fa-heart"></i>
                                {{$isCollect?'取消收藏':'收藏此商品'}}
					    </span>
                            <span class="favorite" onclick="goodsshare()">
                            分享
                        </span>
                        </li>

                        <li>
                            <div class="star_box">
                                <strong class="item">顾客评分：</strong>
                                <span class="star star_0" id="rate" style="margin-top: -20px;width: 150px;height: 70px">
                                </span>
                                <u>(已有{{count($goodsComment)}}人评价)</u>
                            </div>
                        </li>
                        
                        <li id="sku">
                             @foreach($attributes as $k=>$v)
                        <dl>
                                <dt>
                                    {{$v->attrName}}：
                                </dt>
                                <dd>
                                    <ul  class="dowebok">
                                      

                                    @foreach($v->attrValue as $key=>$val)
                                    <li><input type="radio" name="{{$v->attrId}}" value="{{$val->id}}" onclick="attr()" class="labelauty" data-labelauty="{{$val->avName}}"></li>

                                    @endforeach
                                    </ul>
                                </dd>
                            </dl>
                        @endforeach
                        </li>
                            
                        
                            
                       

                        
                        
                        
                        <input type="hidden" name="url" value="{{$url}}">

                        <li>
                            至
                            <a class="sel_area blue" href="javascript:;" name="localArea">当前地区</a>：
                            <span id="deliveInfo"></span>
                            <div class="area_box">
                                <ul>
                                    <li><a data-code="1" href="#J_PostageTableCont"><strong>全部</strong></a></li>
                                    @foreach($province as $k=>$v)
                                        <li><a href="javascript:void(0);" name="areaSelectButton"
                                               value="{{$v->id}}">{{$v->areaName}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <!--商家信息 开始-->
                        <!--商家信息 结束-->
                    </ul>
                    <!--购买区域-->
                    <div class="good_info_buy">

                        <dl>
                            <dt>购买数量：</dt>
                            <dd>
                                <div class="goods_resize">
                                    <span class="reduce" id="dec" onclick="buyNums(this)">─</span>
                                    <input style="display: block; float: left; width: 50px; height: 28px; border: none; outline: 1px solid #ddd; text-align: center; "
                                           type="text" id="buyNums" value="1" maxlength="5"/>
                                    <span class="add" id="add" onclick="buyNums(this)">+</span>
                                </div>
                            </dd>
                        </dl>

                        <div class="btn_submit_buy" id="letsBuy">
                            <i class="fa fa-shopping-cart"></i>
                            <span>立即购买</span>
                        </div>
                        <div class="btn_add_cart" onclick="joinCart()">
                            <i class="fa fa-cart-plus"></i>
                            <span>加入购物车</span>
                        </div>
                    </div>
                </section>
            </section>

            <section class="web">
                <!-- 产品详情 -->
                <section class="products_main">
                    <!-- 详情目录 -->
                    <div class="goods_tab" name="showButton">
                        <label class="current">商品详情</label>
                        <label>顾客评价({{count($goodsComment)}})</label>
                        <label>购买记录(0)</label>
                        <label>购买前咨询(0)</label>
                        <label>网友讨论圈(0)</label>
                    </div>
                    <!-- 详情目录 -->
                    <div class="goods_con" name="showBox">
                        <!-- 商品详情 start -->
                        <div>
                            <ul class="goods_infos">
                                <li>{{$goodsInfo->goodsName}}</li>


                                <li>商品毛重：<label id="data_weight">500.00g</label></li>

                                <li>单位：件</li>

                                <li>上架时间：{{$goodsInfo->addTime}}</li>

                            </ul>
                            <article class="article_content">
                                <h3>产品描述：</h3>
                                <div class="content_tpl">
                                    @foreach($goodsThumb as $k=>$v)
                                        <div class="formwork">
                                            <div class="formwork_img"><img
                                                        src="{{URL::asset($v->gallaryImg)}}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                    <table width="750" border="0" align="center" cellpadding="0" cellspacing="6">
                                        <tr>
                                            <td>
                                                <img src="{{URL::asset($goodsInfo->goodsImg)}}"/>
                                            </td>
                                            <td>
                                                <p class="formwork_titleleft2">
                                                    {{$goodsInfo->goodsDesc}}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <br/>
                                </div>
                                <!-- 商品详情 end -->
                <!-- 顾客评论 start -->
                    <div class="none comment_list">
                        <div id='commentBox'>
                            <div style="width:900px;height:261px;">
                                    @foreach($goodsAppraises as $k=>$v)
                                <div style="width:450px;height:140px; float:left">
                                    <h3>{{$v->content}}</h3>
                                    <img src="{{URL::asset('/')}}{{$v->images}}" alt="" style="width:100px;height:80px;margin-top:5px;">
                                </div>

                                <div style="width:430px;height:140px; float:right;">
                                    <div style="width:110px;height:130px;margin:auto;">
                                            用户:<font style="text-align:center">**{{$username->username}}**</font>
                                            {{$username->createTime}}
                                            {{$v->createTime}}
                                    </div>
                                </div>  @endforeach
                            </div>

                                <!-- 购买记录 start -->
                                <div class="none history_list">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>购买人</th>
                                            <th>出价</th>
                                            <th>数量</th>
                                            <th>购买时间</th>
                                            <th>状态</th>
                                        </tr>
                                        </thead>
                                        <tbody class="dashed" id="historyBox"></tbody>
                                    </table>
                                    <!--购买历史js模板-->
                                    <script type='text/html' id='historyRowTemplate'>
                                        <tr>
                                            <td><strong>游客</strong></td>
                                            <td><em>5456</em></td>
                                            <td><u>2</u></td>
                                            <td>
                                                <time>time</time>
                                            </td>
                                            <td><span>成交</span></td>
                                        </tr>
                                    </script>
                                </div>
                                <!-- 购买记录 end -->

                                <!-- 购买前咨询 start -->
                                <div class="none ask_list ">
                                    <a class="ask_btn" href="/index.php?controller=site&action=consult&id=183">我要咨询</a>
                                    <div id='referBox'></div>
                                    <!--购买咨询JS模板-->
                                    <script type='text/html' id='referRowTemplate'>
                                        <div class="ask_item">
                                            <div class="user">
                                                <img src=""/>
                                                <span></span>
                                            </div>
                                            <div class="desc">
                                                <header>
                                                    <i class="fa fa-comment-alt"></i>
                                                    <strong>咨询内容：</strong>
                                                    <time>时间</time>
                                                </header>
                                                <section>asdfas</section>
                                                <div class="answer">
                                                    <header>
                                                        <i class="fa fa-comments-alt"></i>
                                                        <strong>商家回复：</strong>
                                                        <time>kk</time>
                                                    </header>
                                                    <section>，，，</section>
                                                </div>
                                            </div>
                                        </div>
                                    </script>
                                </div>
                                <!-- 购买前咨询 end -->

                                <!-- 网友讨论圈 start -->
                                <div class="none discussion_list">
                                    <a class="ask_btn" name="discussButton">发表话题</a>
                                    <div id='discussBox'></div>
                                    <!--讨论JS模板-->
                                    <script type='text/html' id='discussRowTemplate'>
                                        <div class="discussion_item">
                                            <strong>saf</strong>
                                            <time>fff</time>
                                            <p>fff</p>
                                        </div>
                                    </script>
                                    <section class="discuss_form none" id="discussTable">
                                        <dl>
                                            <dt>讨论内容：</dt>
                                            <dd><textarea class="input_textarea" id="discussContent" pattern="required"
                                                          alt="请填写内容"></textarea></dd>
                                        </dl>
                                        <dl>
                                            <dt>验证码：</dt>
                                            <dd>
                                                <input type='text' class='input_text w100' name='captcha'
                                                       pattern='^\w{5}$'
                                                       alt='填写下面图片所示的字符'/>
                                                <img src='/index.php?controller=site&action=getCaptcha' id='captchaImg'
                                                     onclick="changeCaptcha()"/>
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt></dt>
                                            <dd><input class="input_submit" type="submit" name="sendDiscussButton"
                                                       value="发表"/></dd>
                                        </dl>
                                    </section>
                                </div>
                                <!-- 网友讨论圈 end -->
                        </div>
                </section>
                <!-- 产品详情 -->
                <!-- 产品详情侧边 -->
                <aside class="products_bar">
                    <div class="products_bar_box">
                        <h3 class="products_bar_box_head">热卖排行</h3>
                        <ul class="products_bar_hot">
                            @foreach($hotGoodsList[0] as $k=>$v)
                                <li>
                                    <a href="{{url('goods/detail')}}?goodsId={{$v['goodsId']}}">
                                        <i class="goods_mark"></i>
                                        <img src="{{URL::asset($v['goodsImg'])}}"
                                             alt="{{$v['goodsName']}}">
                                        <div>
                                            <p class="goods_title">
                                                <span>{{$v['goodsName']}}</span>
                                            </p>
                                            <p class="goods_sell_price">￥{{$v['shopPrice']}}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
                <!-- 产品详情侧边 -->
            </section>
        </div>
        <!--<script type="text/javascript" src="{{URL::asset('home/js/jquery-labelauty.js')}}"></script>-->
        <script>
            function attr()
            {
             var str="";    
            
               $(@json($attributes)).each(function(k,v){
                str+=','+$("input:checked[name="+v.attrId+"]").val();
        
                })
                str=str.substr(1);
                $.ajax({
                url:"{{url('goods/skuPrice')}}",
                data:{str:str},
                dataType:'json',
                type:'get',
                success:function(data){
                if(data.code===1)
                {
                 var price=data.data.price;
                 var num=data.data.num;
                 $("#data_sellPrice").text(price);
                 $("#data_storeNums").text(num);
                 
                }
                  
                    
                    
                }
                
            
            })
                
                
            };
            
            $(function () {
                $(':input').labelauty();
                //初始化商品详情对象
                var productInstance = new productClass("183", "", "", "0");

                //初始化商品轮换图
                $('#goodsPhotoList').bxSlider({
                    infiniteLoop: false,
                    hideControlOnEnd: true,
                    controls: true,
                    pager: false,
                    minSlides: 5,
                    maxSlides: 5,
                    slideWidth: 72,
                    slideMargin: 15,
                    onSliderLoad: function (currentIndex) {
                        //默认初始化显示第一张
                        $('[thumbimg]:eq(' + currentIndex + ')').trigger('click');
                        //放大镜
                        $("#picShow").imagezoom();
                    }
                });

                //城市地域选择按钮事件
                $('.sel_area').hover(
                    function () {
                        $('.area_box').show();
                    }, function () {
                        $('.area_box').hide();
                    }
                );

                $('.area_box').hover(
                    function () {
                        $('.area_box').show();
                    }, function () {
                        $('.area_box').hide();
                    }
                );

                //按钮绑定
                $('[name="showButton"]>label').click(function () {
                    $(this).siblings().removeClass('current');
                    $(this).addClass('current');

                    $('[name="showBox"]>div').hide();
                    $('[name="showBox"]>div:eq(' + $(this).index() + ')').show();

                    switch ($(this).index()) {
                        case 1: {
                            productInstance.comment_ajax();
                        }
                            break;

                        case 2: {
                            productInstance.history_ajax();
                        }
                            break;

                        case 3: {
                            productInstance.refer_ajax();
                        }
                            break;

                        case 4: {
                            productInstance.discuss_ajax();
                        }
                            break;
                    }
                });
            });
            //评分
            layui.use(['rate'], function(){
                var rate = layui.rate;

                //渲染
                var ins1 = rate.render({
                    elem: '#rate',  //绑定元素
                    readonly:true,
                    value:2
                });
            });
        </script>

    </div>
    <!--主要模板内容 结束-->
    <script src="{{URL::asset('home/js/detail1.js')}}"></script>
    <script src="{{URL::asset('home/js/detail2.js')}}"></script>
    <script src="{{URL::asset('home/js/detail3.js')}}"></script>
    <script src="{{URL::asset('home/js/detail4.js')}}"></script>
    <script src="{{URL::asset('home/js/detail5.js')}}"></script>
    <script src="{{URL::asset('home/js/detail6.js')}}"></script>
    <script src="{{URL::asset('home/js/detail7.js')}}"></script>
    <script src="{{URL::asset('home/js/detail8.js')}}"></script>
    <script src="{{URL::asset('home/js/detail9.js')}}"></script>
    <script src="{{URL::asset('home/js/detail10.js')}}"></script>
    <script src="{{URL::asset('home/js/detail11.js')}}"></script>
    <script>
        //当首页时显示分类
        $(function () {
            $('input:text[name="word"]').val("");
        });
    </script>
    <script type="text/javascript">
        _webUrl = "/index.php?controller=_controller_&action=_action_&_paramKey_=_paramVal_";
        _themePath = "/views/huawei/";
        _skinPath = "/views/huawei/skin/default/";
        _webRoot = "/";

        function addFavorite(goodsId) {
            if("{{session()->get('userId')}}"===''){
                layer.msg('您还没有登录哦~',{
                    time:2000,
                    icon:5
                },function () {
                    location.href="{{url('login/login')}}";
                })
            }else {
                $.ajax({
                    url: "{{url('collect/addFavorite')}}",
                    type: 'GET',
                    dataType: 'json',
                    data: {goodsId: goodsId},
                    success: function (res) {
                        if (res.code === 1) {
                            $("#favorite").html('<i class="fa fa-heart"></i>' + res.data);
                            layer.msg(res.message, {
                                time: 1000,
                                icon: 1
                            })
                        } else {
                            layer.msg(res.message, {
                                time: 1000,
                                icon: 2
                            })
                        }
                    }
                })
            }
        }
        //购买数量
        function buyNums(own) {
            var type = $(own).attr('id');
            var buyNums = parseInt($("#buyNums").val());
            if (type === 'add') {
                buyNums = buyNums + 1;
            } else {
                if (buyNums > 1) {
                    buyNums = buyNums - 1;
                }
            }
            $("#buyNums").val(buyNums);
        }
        //添加到购物车
        function joinCart() {
            if("{{session()->get('userId')}}"===''){
                layer.msg('您还没有登录哦~',{
                    time:2000,
                    icon:5
                },function () {
                    location.href="{{url('login/login')}}";
                })
            }else {
                var goodsId = "{{$goodsInfo->goodsId}}";
                var num = $("#buyNums").val();
                $.ajax({
                    url: "{{url('cart/joinCart')}}",
                    type: 'GET',
                    dataType: 'json',
                    data: {goodsId: goodsId, num: num},
                    success: function (res) {
                        if (res.code === 1) {
                            layer.msg(res.message, {
                                time: 1000,
                                icon: 1
                            }, function () {
                                history.go(0)
                            })
                        } else {
                            layer.msg(res.message, {
                                time: 1000,
                                icon: 2
                            })
                        }
                    }
                })
            }
        }
        //商品分享
        function goodsshare() {
            if("{{session()->get('userId')}}"===''){
                layer.msg('您还没有登录哦~',{
                    time:2000,
                    icon:5
                },function () {
                    location.href="{{url('login/login')}}";
                })
            }else{
                var url = $("input[type='hidden']").val();
                alert('请复制以下链接分享给好友<br>' + url);
            }
        }
        //点击购买
        $("#letsBuy").on('click',function (e) {
            e.preventDefault();
            if("{{session()->get('userId')}}"===''){
                layer.msg('您还没有登录哦~',{
                    time:2000,
                    icon:5
                },function () {
                    location.href="{{url('login/login')}}";
                })
            }else {
                var goodsId = ["{{$goodsInfo->goodsId}}"];
                var num = [$("#buyNums").val()];
                var shopId = ["{{$goodsInfo->shopId}}"];
                var goodsMoney = parseFloat("{{$goodsInfo->shopPrice}}") * num;
                var totalMoney = goodsMoney + parseFloat("{{$goodsInfo->freight}}");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    url: "{{url('order/placeOrder')}}",
                    type: "POST",
                    data: {
                        num: num,
                        goodsId: goodsId,
                        shopId: shopId,
                        orderStatus: -2,
                        goodsMoney: goodsMoney,
                        deliverType: 1,
                        totalMoney: totalMoney,
                        realTotalMoney: totalMoney
                    },
                    dataType: 'json',
                    success: function (res) {
                        if (res.code === 1) {
                            location.href = "{{url('order/orderAdd')}}?id=" + res.orderId;
                        } else {
                            layer.msg('购买失败，请稍后再试！');
                        }
                    }
                });
            }
        })



    </script>
@endsection