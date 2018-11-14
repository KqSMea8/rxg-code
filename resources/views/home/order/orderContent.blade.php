@extends("home.left.left")
@section("left")
<section id="member">
<div class="member-center clearfix">
    

    
<div class="member-right fr">
<div class="member-head">
    <div class="member-heels fl"><a href="{{url('order/index')}}"><font color="white"><我的订单</font></a></div>
</div>
<div class="member-border">
   
<div class="member-entry">
<div class="member-issue clearfix">
    <table class="table-bordered" style="line-height: 38px;border: 2px;">
	<tr>
		<td>订单号</td>
		<td>{{$data->orderNo}}</td>
	</tr>
	<tr>
		<td>收货地址</td>
		<td>{{$data->userAddress}}</td>
	</tr>
	<tr>
		<td>订单时间</td>
		<td>{{$data->addTime}}</td>
	</tr>
	<tr>
		<td>订单状态</td>
                <td>
                    @if($data->orderStatus==-3)
                    用户拒收
                    @elseif($data->orderStatus==-2)
                    未付款
                    @elseif($data->orderStatus==-1)
                    用户取消
                    @elseif($data->orderStatus==3)
                    待发货
                    @elseif($data->orderStatus==1)
                    配送中
                    @elseif($data->orderStatus==2)
                    用户确认收货
                    @endif
                </td>
	</tr>
	<tr>
		<td>订单金额</td>
		<td>{{$data->realTotalMoney}}</td>
	</tr>
	<tr>
		<td>物流公司</td>
		<td>{{$data->expressName}}</td>
	</tr>
	<tr>
		<td>支付方式</td>
                <td>
                    @if($data->payType==0 && $data->orderStatus<>-2)
                    货到付款
                    @elseif($data->payType==1 && $data->orderStatus<>-2)
                    在线支付
                    @endif
                </td>
	</tr>
	<tr>
		<td>收件人姓名</td>
		<td>{{$data->username}}</td>
	</tr>
	<tr>
		<td>收件人联系电话</td>
		<td>{{$data->userPhone}}</td>
	</tr>
	<tr>
		<td>商品名称</td>
		<td>{{$data->goodsName}}</td>
	</tr>
        <tr>
		<td>店铺名称</td>
		<td>{{$data->shopName}}</td>
	</tr>
        <tr>
		<td>所得积分</td>
		<td>{{$data->orderScore}}</td>
	</tr>
        <tr>
		<td>订单备注</td>
		<td>{{$data->orderRemarks}}</td>
	</tr>
</table>

</div>

</div>
</div>
</div>
</div>
</section>

@endsection

