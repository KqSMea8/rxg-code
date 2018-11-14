@extends('home.layout.layout')
@section('content')
    <div class="yHeader">
        <!-- 导航   start  -->
        <div class="yNavIndex">
            <div class="pullDown">
                <h2 class="pullDownTitle"><i class="icon-class"></i>所有商品分类</h2>
                <ul class="pullDownList">
                    @foreach($catList as $k=>$v)
                        <li class="" data-id="{{$k}}">
                            <i class=""></i>
                            <a href="">{{$v['catName']}}</a>
                            <span></span>
                        </li>
                    @endforeach
                </ul>
                <!-- 下拉详细列表具体分类 -->
                <div class="yMenuListCon">
                    @foreach($catList as $k=>$v)
                        <div class="yMenuListConin">
                            <div class="yMenuLCinList">
                                <h3><a href="" class="yListName"></a><a href="" class="yListMore">更多 ></a></h3>
                                <p></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <ul class="yMenuIndex">
                <li><a href="{{url('/')}}">任性购首页</a></li>
                <li><a href="{{url('shop/shops')}}">店铺中心 </a></li>
                <li><a href="{{url('order/index')}}">我的订单</a></li>
                <li><a href="{{url('collect/favoriteGoods')}}">我的收藏</a></li>
            <!--<li><a href="{{url('merchant/register')}}">商家入驻</a></li>-->
            </ul>
        </div>
        <!-- 导航   end  -->
    </div>
    <!-- 购物车 -->
    </header>
    <section id="pc-jie">
        <div class="center">
            <ul class="pc-shopping-title clearfix">
                <li><a href="#" class="cu">全部商品({{count($userCarts)}})</a></li>
            </ul>
        </div>
        <div class="pc-shopping-cart center">
            <div class="pc-shopping-tab">
                <table>
                    <thead>
                    <tr class="tab-0">
                        <th class="tab-1">
                            <input type="checkbox" name="s_all" class="s_all tr_checkmr"
                                   id="s_all_h" {{$isAllCheck?'checked':''}}>
                            <label for=""> 全选</label></th>
                        <th class="tab-2">商品</th>
                        <th class="tab-3">商品信息</th>
                        <th class="tab-4">单价</th>
                        <th class="tab-5">数量</th>
                        <th class="tab-6">小计</th>
                        <th class="tab-7">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="7" style="padding-left:10px; background:#eee">
                        </td>
                    </tr>
                    @foreach($userCarts as $k=>$v)
                        <tr id="{{$v['cartId']}}">
                            <th>
                                <input type="checkbox" value="{{$v['cartId']}}"
                                       style="margin-left:10px; float:left"
                                       {{$v['isCheck']?'checked':''}} onclick="checkOne(this)" name="cartCheck">
                                <input type="hidden" id="shopId{{$v['cartId']}}" value="{{$v['shopId']}}">
                                <input type="hidden" id="goodsId{{$v['cartId']}}" value="{{$v['goodsId']}}">
                            </th>
                            <th class="tab-th-1">
                                <a href="#"><img src="{{URL::asset($v['goodsImg'])}}" height="100%" width="100%"></a>
                                <a href="#" class="tab-title">{{$v['goodsName']}}</a>
                            </th>
                            <th>
                                <p>{{$v['goodsDesc']}}</p>
                            </th>
                            <th>
                                <p class="red">
                                    ￥<span id="uPrice{{$v['cartId']}}">
                                        {{$v['shopPrice']}}
                                    </span>
                                </p>
                            </th>
                            <th class="tab-th-2">
                                <input type="button" class="shul" style="display:inline-block;width: 30px" data-id="{{$v['cartId']}}" id="dec" value="-">
                                <input type="text" value="{{$v['num']}}" maxlength="3" placeholder="" class="shul" id="num{{$v['cartId']}}" disabled>
                                <input type="button" class="shul" style="display:inline-block;width: 30px"
                                   data-id="{{$v['cartId']}}" id="add" value="+">
                            </th>
                            <th class="red">￥
                                <span id="sCount{{$v['cartId']}}">{{($v['num'])*($v['shopPrice'])}}</span>
                            </th>
                            <th>
                                <a href="javascript:;" onclick="delOne({{$v['cartId']}})">删除</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="height:10px"></div>
        <div class="center">
            <div class="clearfix pc-shop-go">
                <div class="fl pc-shop-fl">
                    <a href="javascript:;" onclick="delCheck()">删除所选（<span id="checkNum">{{$checkNum}}</span>）</a>
                </div>
                <div class="fr pc-shop-fr">
                    <p>共有 <em class="red pc-shop-shu" id="cartNum">{{$checkNum}}</em> 款商品，总计（不含运费）</p>
                    <span>¥<font id="count">{{$count}}</font>
                    </span>
                    <a href="javascript:;" onclick="letsBuy()">去结算</a>
                </div>
            </div>
        </div>
    </section>
    <script>
        // 购物车商品-1
        $("input#dec").on('click', function () {
            var cartId = $(this).attr('data-id');
            var numO = $("#num" + cartId);
            var sCountO = $("#sCount" + cartId);
            var uPrice = $("#uPrice" + cartId).text();
            var countO = $("#count");
            if (parseInt(numO.val()) > 1) {
                var num = parseInt(numO.val()) - 1;
                numO.val(num);
                sCountO.text(uPrice * num);
                countO.text(parseFloat(countO.text()) - parseFloat(uPrice));
                $.ajax({
                    url: "{{url('cart/cartNumC')}}",
                    type: 'GET',
                    data: {cartId: cartId, num: num, type: 'dec'},
                    dataType: 'json',
                    success: function (res) {
                        console.log(res)
                    }
                })
            }
        });
        // 购物车商品+1
        $("input#add").on('click', function () {
            var cartId = $(this).attr('data-id');
            var numO = $("#num" + cartId);
            var sCountO = $("#sCount" + cartId);
            var uPrice = $("span#uPrice" + cartId).text();
            var countO = $("#count");
            var num = parseInt(numO.val()) + 1;
            numO.val(num);
            sCountO.text(uPrice * num);
            countO.text(parseFloat(countO.text()) + parseFloat(uPrice));
            $.ajax({
                url: "{{url('cart/cartNumC')}}",
                type: 'GET',
                data: {cartId: cartId, num: num, type: 'add'},
                dataType: 'json',
                success: function (res) {
                    console.log(res)
                }
            })
        });

        // 购物车信息单删
        function delOne(cartId) {
            var arr = new Array();
            arr.push(cartId);
            $.ajax({
                url: "{{url('cart/cartDel')}}",
                data: {cartId: arr},
                dataType: 'json',
                type: 'GET',
                success: function (res) {
                    if (res.code === 1) {
                        $("tr#" + cartId).remove();
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
                    history.go(0)
                }
            })
        }

        //商品的是否选择并在后台修改
        function checkOne(obj) {
            var own = $(obj);
            var cartId = own.val();
            var checkStatus = own.prop('checked');
            var sCount = $("#sCount" + cartId).text();
            var countO = $("#count");
            var cartNumO = $("em#cartNum");
            if (checkStatus) {
                var count = parseFloat(countO.text()) + parseFloat(sCount);
                var cartNum = parseInt(cartNumO.text()) + 1;
            } else {
                var count = parseFloat(countO.text()) - parseFloat(sCount);
                var cartNum = parseInt(cartNumO.text()) - 1;
            }
            countO.text(count);
            cartNumO.text(cartNum);
            $("#checkNum").text(cartNum);
            isAllCheck();
            var arr = new Array();
            arr.push(cartId);
            $.ajax({
                url: "{{url('cart/cartCheck')}}",
                type: "GET",
                dataType: 'json',
                data: {isCheck: checkStatus ? 1 : 0, cartId: arr},
                success: function (res) {
                    if (res.code === 0) {
                        history.go(0)
                    }
                }
            })
        }

        //点击全选让子复选框动也被选择或不选择
        $("#s_all_h").on('click', function () {
            var own = $(this);
            var checkStatus = own.prop('checked');
            var childCheck = $("input[name='cartCheck']");
            var countO = $("#count");
            var cartNumO = $("em#cartNum");
            var arr = new Array();
            if (checkStatus) {
                countO.text("{{$rCount}}");
                cartNumO.text("{{$rCheckNum}}");
                $("#checkNum").text("{{$rCheckNum}}");
            } else {
                countO.text(0);
                cartNumO.text(0);
                $("#checkNum").text(0);
            }
            childCheck.each(function (k, v) {
                arr.push($(v).val());
                $(v).prop('checked', checkStatus)
            });
            $.ajax({
                url: "{{url('cart/cartCheck')}}",
                type: "GET",
                dataType: 'json',
                data: {isCheck: checkStatus ? 1 : 0, cartId: arr},
                success: function (res) {
                    if (res.code === 0) {
                        history.go(0)
                    }
                }
            })
        });

        //判断全选按钮的勾选状态
        function isAllCheck() {
            var childCheck = $("input[name='cartCheck']");
            var isAllcheck = true;
            childCheck.each(function (k, v) {
                if ($(v).prop('checked') === false) {
                    isAllcheck = false;
                }
            });
            $("#s_all_h").prop('checked', isAllcheck);
        }

        //购物车商品的批量删除
        function delCheck() {
            var childCheck = $("input[name='cartCheck']");
            var arr = new Array();
            childCheck.each(function (k, v) {
                if ($(v).prop('checked') === true) {
                    arr.push($(v).val());
                }
            });
            $.ajax({
                url: "{{url('cart/cartDel')}}",
                data: {cartId: arr},
                dataType: 'json',
                type: 'GET',
                success: function (res) {
                    if (res.code === 1) {
                        $(arr).each(function (k, v) {
                            $("tr#" + v).remove();
                        });
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
                    history.go(0)
                }
            })
        }
        //点击购买
        function letsBuy() {
            var childCheck = $("input[name='cartCheck']");
            var goodsId = new Array();
            var num = new Array();
            var shopId = new Array();
            var cartId = new Array();
            childCheck.each(function (k, v) {
                if ($(v).prop('checked') === true) {
                    var value = $(v).val();
                    goodsId.push($("#goodsId"+value).val());
                    num.push($("#num"+value).val());
                    shopId.push($("#shopId"+value).val());
                    cartId.push($(v).val());
                }
            });
            var goodsMoney = $("#count").text();
            var totalMoney = goodsMoney;
            $.ajax({
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                url:"{{url('order/placeOrder')}}",
                type:"POST",
                data:{
                    num:num,
                    goodsId:goodsId,
                    orderStatus:-2,
                    goodsMoney:goodsMoney,
                    deliverType:1,
                    shopId:shopId,
                    cartId:cartId,
                    totalMoney:totalMoney,
                    realTotalMoney:totalMoney
                },
                dataType:'json',
                success:function (res) {
                    if(res.code===1){
                        location.href="{{url('order/orderAdd')}}?id="+res.orderId;
                    }else{
                        layer.msg('购买失败，请稍后再试！');
                    }
                }
            });
        }
    </script>
@endsection