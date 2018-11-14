@extends('home.left.left')
@section('left')
<!-- 退货申请 -->
		@foreach($data as $k => $v)
		<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>退货申请</h2></div>
				<form action="{{url('sales/sales')}}">
                    <div class="member-backs member-icons fr"><button class="btn btn-primary" style="margin-top: -15px;">搜索</button></div>
                    <div class="member-about fr"><input placeholder="商品名称/商品编号/订单编号" type="text" name="keywords"></div>
                </form>
            </div>
			<div class="member-border">
				<div class="member-newly">
					<span><b>订单号：</b>{{$v->orderNo}}</span> 
					<span>
                        <b>订单状态：</b>
						<i class="reds">
							@if($v->orderStatus==-3) 用户拒收
                                @elseif($v->orderStatus==-2)未付款
                                @elseif($v->orderStatus==-1) 用户取消 
                                @elseif($v->orderStatus==3) 待发货
                                @elseif($v->orderStatus==1) 配送中
                                @elseif($v->orderStatus==2) 用户确认收货
                            @endif
						</i>
					</span>
				</div>
				<div class="member-cargo">
					<h3>收货人信息：</h3>
					<p>{{$v->username}}</p>
					<p>{{$v->tel}}</p>
				</div>
				<div class="member-cargo">
					<h3>店铺名称：{{$v->shopName}}</h3>
					
				</div>
				
				<div class="member-sheet clearfix">
					<ul>
						<li>
							<div class="member-circle clearfix">
								<div class="member-apply clearfix">
									<div class="ap1 fl">
										<span class="gr1"><a href="#"><img src="{{URL::asset('/')}}{{$v->goodsImg}}" title="" about="" width="60" height="60"></a></span>
										<span class="gr2"><a href="#">{{$v->goodsName}}</a></span>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="member-modes clearfix">
					<p class="clearfix"><b>订单合计金额：</b><em> ￥{{$v->totalMoney}}</em></p>
				</div>
				<form action="post" id="form">
				<input type="hidden" name="id" value="{{$v->orderId}}">
				<div>
					<ul>
						<li>
							<div class="member-modes clearfix">
								<p class="clearfix"><b>退款原因：</b>
									<em>
										<select name="cancelReason" id="cancelReason">
											<option value="">请选择</option>
											<option value="收到货物与商品不符">收到货物与商品不符</option>
											<option value="收到货物与自身不合适">收到货物与自身不合适</option>
											<option value="质量差">质量差</option>
											<option value="收到物品为假货">收到物品为假货</option>
											<option value="物流太慢">物流太慢</option>
										</select>
									</em>
								</p>
							</div>
						</li>
						<li>
							<div class="member-modes clearfix">
								<p class="clearfix"><b>备注：</b>
									<em>
										<textarea name="remark" id="" cols="30" rows="10"></textarea>
									</em>
								</p>
							</div>
						</li>
						<li>
							<div class="member-circle clearfix">
								<div class="member-apply clearfix">
									<div class="ap2 fl"><a href="{{url('order/index')}}">查看订单</a> </div>
									<div class="ap3 fl"><a href="javascript:void(0)" id="data" >申请退款</a> </div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				</form>
			</div>
		</div>
		@endforeach
	</div>
</section>

<script>
    $("#data").on('click',function (e){
    	e.preventDefault();
        var data = new FormData($("#form")[0]); 
        $.ajax({
        	headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
            url:"{{url('sales/salesUp')}}",
            dataType:"json",
            type:'post',
            data:data,
            cache: false,
	        processData: false,
	        contentType: false,
            success:function(res){
                    // alert(res.message);return
                if (res.code == 1) {
                layer.msg(res.message,{
                    time:1000,
                    icon:1
                    },function(){
                        window.location.href="{{url('order/index')}}";
                    })
                }else{
                    layer.msg(res.message,{
                        time:1000,
                        icon:2
                    });
                }
            }
        })
    })
</script>
@endsection