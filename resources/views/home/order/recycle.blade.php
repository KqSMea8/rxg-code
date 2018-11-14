@extends('home.left.left')
@section('left')
<div class="member-right fr">
<div class="member-head" style="background-color: rgba(0,0,0,0);;">
    <div class="member-heels fl"><h2 style="margin-top: 2px;color: #000;">我的订单</h2></div>
</div>
<div class="member-whole clearfix">
<ul id="H-table" class="H-table">
<li class="cur"><a href="{{url('order/index')}}">全部订单</a></li>
<li><a href="{{url('order/daiPay')}}?id=-2">待付款<em></em></a></li>
<li><a href="{{url('order/daifa')}}?id=3">待发货</a></li>
<li><a href="{{url('order/daishou')}}?id=1">待收货</a></li>
<li style="float: right;"><a href="{{url('order/recycle')}}">订单回收站</a></li>
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
    <span>下单时间：<em>{{$v->addTime}}</em> 
</span>
<span>订单号：<em>{{$v->orderNo}}</em></span>
<span><a href="{{url('order/shopGoods')}}?id={{$v->shopId}}"><font color="red">{{$v->shopName}}</font></a></span>
<span class="member-custom">客服电话：<em>{{$v->shopTel}}</em></span>
</div>
    <div class="member-circle clearfix">
<div class="ci1">
    <div class="ci7 clearfix" style="height: 145px;">
<span class="gr1"><a href="#"><img src="{{URL::asset('/')}}{{$v->goodsImg}}" title="" about="" width="144px" height="130px"></a></span>
<div style="margin-top: 10px;width: 200px;height: 100px;word-wrap: break-word;margin-left: 180px; word-wrap: break-word; word-break: normal;"><span class="gr2" style=""><a href="{{url('order/goodContent')}}?id={{$v->orderId}}" id="goodsName">商品名称：<font color="blue">{{$v->goodsName}}</font><br><br><div style="width: 200px;height: 80px;word-wrap: break-word;">{{$v->goodsDesc}}</div></a></span></div>
<!--<span style="float:right;margin-top: -10px;">X{{$v->goods_num}}</span>-->
<!--<span class="gr3"><input type="button" value="+"  orderPrice="{{$v->shopPrice}}" data-id="{{$v->orderId}}" class="jia" /><input type="text" value="1"  style="width: 20px" id="num{{$v->orderId}}" disabled=""/><input type="button" value="--"  class="jian" orderPrice="{{$v->shopPrice}}" data-id="{{$v->orderId}}" />-->
</span>
</div>

</div>
<div class="ci2">{{$v->username}}</div>
<div class="ci3"><b id="shopPrice{{$v->orderId}}">{{$v->shopPrice}}</b><p>@if($v->payType==0 && $v->orderStatus<>-2) 货到付款 @elseif($v->payType==1 && $v->orderStatus<>-2) 在线支付 @endif</p><p class="iphone">手机订单</p></div>
<div class="ci4"><p>{{$v->addTime}}<br><br><br>@if($v->isRefund==0 && $v->orderStatus!=-2) <a href="{{url('sales/salesList')}}?id={{$v->orderId}}"><font color="red"></font></a> @elseif($v->isRefund==1)   @endif</p></div>
<div class="ci5">
   
</p> 
<p><a href="#"><p>@if($v->orderStatus==2) 交易成功 @else 交易关闭 @endif</p> <font color="blue"></font></a></p> <p><a href="{{url('order/orderContent')}}?id={{$v->orderId}}">订单详情</a></p>    </div>
<!--<div class="ci5 ci8"> 
<p>@if($v->orderStatus==-2) <a href="{{url('order/orderAdd')}}?id={{$v->orderId}}" class="member-touch">
<font color="red">立即支付</font></a> 
@elseif($v->orderStatus==3) <a class="member-touch">等待发货</a> 
@elseif($v->orderStatus==1)<a href="{{url('order/orderHuo')}}?id={{$v->orderId}}" class="member-touch">确认收货</a> 
@elseif($v->orderStatus==2)<a><font color="green">订单完成</font></a>
@endif </p> <p> 
@if($v->orderStatus==2) <a href="{{url('order/resetOrder')}}?id={{$v->orderId}}">删除订单</a> 
@else <a href="{{url('order/resetOrder')}}?id={{$v->orderId}}">取消订单</a>
@endif</p></div>-->

@if($v->orderStatus===2)
<p style="text-align: center;line-height: 30px;margin-top: 50px;"><a href="#">追加评论</a></p>
<p  style="text-align: center;"><a href="{{url('order/restoreOrder')}}?id={{$v->orderId}}">还原订单</a></p>
@else
<p style="text-align: center;line-height: 30px;margin-top: 50px;"><a href="{{url('order/restoreOrder')}}?id={{$v->orderId}}">还原订单</a></p>
@endif


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

<div class="clearfix" id="pull_right">
    <div  style="float: right" class="pull-right">
{{$data->links()}}
</div>
</div>
</div>
</div>
<script>
    
    
    
$(".jia").click(function(){

    var id=$(this).attr("data-id");
    var ice=$(this).attr("orderPrice");
    var numO = $(this).next();
    var num=parseInt(numO.val());
    num++;
    numO.val(num);
    
    var orice=$("#shopPrice"+id).text();
    var price=num*ice;
    $("#shopPrice"+id).text(price);
    
    
});
$(".jian").click(function(){
     var id=$(this).attr("data-id");
    var ice=$(this).attr("orderPrice");
    
    
   var numO = $(this).prev();
   if(parseInt(numO.val())>1)
   {
       var num=parseInt(numO.val());
   
    num--;
    numO.val(num);
    var orice=$("#shopPrice"+id).text();
    var price=num*ice;
    $("#shopPrice"+id).text(price);
    
    
   }
  
    
    
    
    
        
});
$("#sou").on('click',function () {
    $("#form").submit();
})



</script>


@endsection

