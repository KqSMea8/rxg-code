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


<style>
    *{
        margin:0;
        padding:0;
    }
    ul,ol{
        list-style:none;
    }
    body{
        font-family: "Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;
    }
    .tab-head{
        margin-left:120px;
        margin-bottom:10px;
    }
    .tab-content{
        clear:left;
        display: none;
    }
   
    .selected{
        color: #FFFFFF;
        background-color: #02aaf1;
    }
    .show{
        clear:left;
        display: block;
    }
    .hidden{
        display:none;
    }
    .new-btn-login-sp{
        padding: 1px;
        display: inline-block;
        width: 75%;
    }
    .new-btn-login {
        background-color: #02aaf1;
        color: #FFFFFF;
        font-weight: bold;
        border: none;
        width: 100%;
        height: 30px;
        border-radius: 5px;
        font-size: 16px;
    }
    #main{
        width:100%;
        margin:0 auto;
        font-size:14px;
    }
    .red-star{
        color:#f00;
        width:10px;
        display:inline-block;
    }
    .null-star{
        color:#fff;
    }
    .content{
        margin-top:30px;
    }
    .content dt{
        width:100px;
        display:inline-block;
        float: left;
        margin-left: 20px;
        color: #666;
        font-size: 13px;
        margin-top: 8px;
    }
    .content dd{
        margin-left:120px;
        margin-bottom:5px;
    }
    .content dd input {
        width: 85%;
        height: 28px;
        border: 0;
        -webkit-border-radius: 0;
        -webkit-appearance: none;
    }
    #foot{
        margin-top:10px;
        position: absolute;
        bottom: 15px;
        width: 100%;
    }
    .foot-ul{
        width: 100%;
    }
    .foot-ul li {
        width: 100%;
        text-align:center;
        color: #666;
    }
    .note-help {
        color: #999999;
        font-size: 12px;
        line-height: 130%;
        margin-top: 5px;
        width: 100%;
        display: block;
    }
    #btn-dd{
        margin: 20px;
        text-align: center;
    }
    .foot-ul{
        width: 100%;
    }
    .one_line{
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #eeeeee;
        width: 100%;
        margin-left: 20px;
    }
    .am-header {
        display: -webkit-box;
        display: -ms-flexbox;
        display: box;
        width: 100%;
        position: relative;
        padding: 7px 0;
        -webkit-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
        background: #1D222D;
        height: 50px;
        text-align: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        box-pack: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        box-align: center;
    }
    .am-header h1 {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        box-flex: 1;
        line-height: 18px;
        text-align: center;
        font-size: 18px;
        font-weight: 300;
        color: #fff;
    }
</style>


<div id="main">
    
        <form name="alipayment" action="{{url('order/pagepay')}}" method="post" target="_blank">
            {{csrf_field()}}
            <div id="body1" class="show" name="divcontent">
                <dl class="content">
                    <dt>订单号
：</dt>
                    <dd>
                        {{$orderNo['orderNo']}}
                        <!--<input type="text" id="WIDout_trade_no" name="WIDout_trade_no" value="{{$orderNo['orderNo']}}" readonly />-->
                    </dd>
                    <hr class="one_line">
                    <dt>订单名称
：</dt>
                    <dd>
                        {{$orderNo['goodsName']}}
<!--                        <input id="WIDsubject" name="WIDsubject"  value="{{$orderNo['goodsName']}}" readonly />-->
                    </dd>
                    <hr class="one_line">
                    <dt>付款金额
：</dt>
                    <dd>
                        {{$orderNo['orderMoney']}}
                        <!--<input id="WIDtotal_amount" name="WIDtotal_amount"  value="{{$orderNo['orderMoney']}}" readonly />-->
                    </dd>
                    <hr class="one_line">
                    <dt>商品描述：</dt>
                    <dd>
                       {{$orderNo['orderRemarks']}}
                        <!--<input id="WIDbody" name="WIDbody" readonly  />-->
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;" id='payMoney'>付 款</button>
                        </span>
                        <span class="note-help">如果您点击“付款”按钮，即表示您同意该次的执行操作。</span>
                    </dd>
                </dl>
            </div>
		</form>
<!--        <form name=tradequery action=pagepay/query.php method=post target="_blank">
            {{csrf_field()}}
            <div id="body2" class="tab-content" name="divcontent">
                <dl class="content">
                    <dt>商户订单号
：</dt>
                    <dd>
                        <input id="WIDTQout_trade_no" name="WIDTQout_trade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>支付宝交易号
：</dt>
                    <dd>
                        <input id="WIDTQtrade_no" name="WIDTQtrade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                     <dd>
                        <span style="line-height: 28px; color:red;">注意：商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no</span>
                    </dd>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">交 易 查 询</button>
                        </span>
                        <span class="note-help">商户订单号与支付宝交易号二选一，如果您点击“交易查询”按钮，即表示您同意该次的执行操作。</span> 
                    </dd>
                </dl>
            </div>
        </form>
        <form name=traderefund action=pagepay/refund.php method=post target="_blank">
            <div id="body3" class="tab-content" name="divcontent">
                <dl class="content">
                    <dt>商户订单号
：</dt>
                    <dd>
                        <input id="WIDTRout_trade_no" name="WIDTRout_trade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>支付宝交易号
：</dt>
                    <dd>
                        <input id="WIDTRtrade_no" name="WIDTRtrade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>退款金额
：</dt>
                    <dd>
                        <input id="WIDTRrefund_amount" name="WIDTRrefund_amount" />
                    </dd>
                    <hr class="one_line">
                    <dt>退款原因
：</dt>
                    <dd>
                        <input id="WIDTRrefund_reason" name="WIDTRrefund_reason" />
                    </dd>
                    <hr class="one_line">
                    <dt>退款请求号
：</dt>
                    <dd>
                        <input id="WIDTRout_request_no" name="WIDTRout_request_no" />
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                    <dd>
                        <span style="line-height: 28px; color:red;">注意：如是部分退款，则参数退款单号（out_request_no）必传。</span>
                    </dd>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">退 款</button>
                        </span>
                        <span class="note-help">商户订单号与支付宝交易号二选一，如果您点击“退款”按钮，即表示您同意该次的执行操作。</span> 
                    </dd>
                </dl>
            </div>
        </form>
        <form name=traderefundquery action=pagepay/refundquery.php method=post target="_blank">
            {{csrf_field()}}
            <div id="body4" class="tab-content" name="divcontent">
                
                <dl class="content">
                    <dt>商户订单号
：</dt>
                    <dd>
                        <input id="WIDRQout_trade_no" name="WIDRQout_trade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>支付宝交易号
：</dt>
                    <dd>
                        <input id="WIDRQtrade_no" name="WIDRQtrade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>退款请求号
：</dt>
                    <dd>
                        <input id="WIDRQout_request_no" name="WIDRQout_request_no" />
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                    <dd>
                        <span style="line-height: 28px; color:red;">注意：退款请求号值（必传，退款时传的值，如果退款时没传则无法查询）商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no</span>
                    </dd>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">退 款 查 询</button>
                        </span>
                        <span class="note-help">商户订单号与支付宝交易号二选一，如果您点击“退款查询”按钮，即表示您同意该次的执行操作。</span> 
                    </dd>
                </dl>
            </div>
        </form>
        <form name=tradeclose action=pagepay/close.php method=post target="_blank">
            {{csrf_field()}}
            <div id="body5"  class="tab-content" name="divcontent">
                <dl class="content">
                    <dt>商户订单号
：</dt>
                    <dd>
                        <input id="WIDTCout_trade_no" name="WIDTCout_trade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>支付宝交易号
：</dt>
                    <dd>
                        <input id="WIDTCtrade_no" name="WIDTCtrade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                    <dd>
                        <span style="line-height: 28px; color:red;">注意：商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no</span>
                    </dd>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">交 易 关 闭</button>
                        </span>
                        <span class="note-help">商户订单号与支付宝交易号二选一，如果您点击“交易关闭”按钮，即表示您同意该次的执行操作。</span> 
                    </dd>
                </dl>
            </div>
        </form>-->
</body>
<script language="javascript">
    var tabs = document.getElementsByName('tab');
    var contents = document.getElementsByName('divcontent');
    
    $("#payMoney").on("click",function(e){
        e.preventDefault();
        var WIDout_trade_no="{{$orderNo['orderNo']}}";
        var WIDsubject = "{{$orderNo['goodsName']}}";
        var WIDtotal_amount="{{$orderNo['orderMoney']}}";
        var WIDbody="{{$orderNo['orderRemarks']}}";
        
        window.location.href="{{url('order/pagepay')}}?WIDout_trade_no="+WIDout_trade_no+"&WIDsubject="+WIDsubject+"&WIDtotal_amount="+WIDtotal_amount+"&WIDbody="+WIDbody;
        
    })




//    (function changeTab(tab) {
//        for(var i = 0, len = tabs.length; i < len; i++) {
//            tabs[i].onmouseover = showTab;
//        }
//    })();
//
//    function showTab() {
//        for(var i = 0, len = tabs.length; i < len; i++) {
//            if(tabs[i] === this) {
//                tabs[i].className = 'selected';
//                contents[i].className = 'show';
//            } else {
//                tabs[i].className = '';
//                contents[i].className = 'tab-content';
//            }
//        }
//    }

//	function GetDateNow() {
//		var vNow = new Date();
//		var sNow = "";
//		sNow += String(vNow.getFullYear());
//		sNow += String(vNow.getMonth() + 1);
//		sNow += String(vNow.getDate());
//		sNow += String(vNow.getHours());
//		sNow += String(vNow.getMinutes());
//		sNow += String(vNow.getSeconds());
//		sNow += String(vNow.getMilliseconds());
//		document.getElementById("WIDout_trade_no").value =  sNow;
//		document.getElementById("WIDsubject").value = "测试";
//		document.getElementById("WIDtotal_amount").value = "0.01";
//	}
	GetDateNow();
</script>
</html>
@endsection