@extends('home.left.left')
@section('left')
<div class="member-right fr">
<div class="member-head" style="background-color: rgba(0,0,0,0);;">
    <div class="member-heels fl"><h2 style="margin-top: 2px;color: #000;">我的订单</h2></div>
<form action="{{url('order/index')}}">
<!--<div class="member-backs member-icons fr"><button class="btn " style="margin-top: -15px;background:none;color: black">搜索</button></div>
<div class="member-about fr"><input placeholder="商品名称/订单编号/" type="text" name="keywords" ></div>-->
</form>
</div>
<div class="member-whole clearfix">
<ul id="H-table" class="H-table">
<li><a href="{{url('order/index')}}">全部订单</a></li>
<li class="cur"><a href="{{url('order/daiPay')}}?id=-2">待付款<em></em></a></li>
<li><a href="{{url('order/daifa')}}?id=3">待发货</a></li>
<li><a href="{{url('order/daishou')}}?id=1">待收货</a></li>
</ul>
</div>
<div class="member-border">
<div class="member-return H-over">
<div class="member-cancel clearfix">
<span class="be1">订单信息</span>
<span class="be2">收货人</span>
<span class="be2">订单金额</span>
<span class="be2">订单时间</span>
<span class="be2">订单状态</span>
<span class="be2">订单操作</span>
</div>
<div class="member-sheet clearfix">
<ul>
    @foreach($data as $k=>$v)
<li>
<div class="member-minute clearfix">
<span>下单时间：<em>{{$v->addTime}}</em></span>
<span>订单号：<em>{{$v->orderNo}}</em></span>
<span><a href="#">{{$v->shopName}}</a></span>
<span class="member-custom">客服电话：<em>{{$v->shopTel}}</em></span>
</div>
<div class="member-circle clearfix">
<div class="ci1">
<div class="ci7 clearfix" style="height: 145px;">
<span class="gr1"><a href="#"><img src="{{URL::asset('/')}}{{$v->goodsImg}}" title="" about="" width="144px" height="130px"></a></span>
<div style="margin-top: 10px;width: 200px;height: 100px;word-wrap: break-word;margin-left: 180px; word-wrap: break-word; word-break: normal;"><span class="gr2" style=""><a href="{{url('order/goodContent')}}?id={{$v->orderId}}" id="goodsName">商品名称：<font color="blue">{{$v->goodsName}}</font><br><br><div style="width: 200px;height: 80px;word-wrap: break-word;">{{$v->goodsDesc}}</div></a></span></div>
<!--<span class="gr3">      <input type="button" value="+"  class="jia" /><input type="text" value="1"  style="width: 20px" id="num{{$v->orderId}}" disabled=""/><input type="button" value="--"  class="jian" />-->
<span style="float:right;margin-top: -10px;">X{{$v->goods_num}}</span>
</span>
</div>

</div>
<div class="ci2">{{$v->username}}</div>
<div class="ci3"><b>￥120.00</b><p>@if($v->payType==0) 货到付款 @elseif($v->payType==1) 在线支付 @endif</p><p class="iphone">手机订单</p></div>
<div class="ci4"><p>{{$v->addTime}}</p></div>
<div class="ci5">
    <p>
   @if($v->orderStatus==-2) <font color="red">未付款</font> 
  
   @endif
</p> 
<p><a href="{{url("order/logistics")}}"><font color="blue">物流跟踪</font></a></p> <p><a href="{{url('order/orderContent')}}?id={{$v->orderId}}">订单详情</a></p></div>
<div class="ci5 ci8"><p>剩余15时20分</p> <p><a href="{{url('order/orderAdd')}}?id={{$v->orderId}}" class="member-touch">立即支付</a> </p> <p><a href="{{url('order/resetOrder')}}?id={{$v->orderId}}">取消订单</a> </p></div>
</div>
</li>
@endforeach

</ul>
</div>
</div>
<div class="H-over member-over" style="display:none;"><h2>待发货</h2></div>
<div class="H-over member-over" style="display:none;"><h2>待收货</h2></div>
<div class="H-over member-over" style="display:none;"><h2>交易完成</h2></div>
<div class="H-over member-over" style="display:none;"><h2>订单信息</h2></div>

<div class="clearfix" style="padding:30px 20px;">
<div  style="float: right">
{{$data->links()}}
</div>
</div>
</div>
</div>
<script>
$(".jia").click(function(){
    
   var numO = $(this).next();
    var num=parseInt(numO.val());
    num++;
    numO.val(num);
    
    
    
        
});
$(".jian").click(function(){
    
   var numO = $(this).prev();
   if(parseInt(numO.val())>1)
   {
       var num=parseInt(numO.val());
   
    num--;
    numO.val(num);
   }
  
    
    
    
    
        
});



</script>


@endsection

