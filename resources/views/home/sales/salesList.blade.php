@extends('home.left.left')
@section('left')
<!-- 退货记录 -->
	
		<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>退货/退款记录</h2></div>
                <form action="{{url('sales/sales')}}">
				<div class="member-backs member-icons fr"><button class="btn btn-primary" style="margin-top: -15px;">搜索</button></div>
				<div class="member-about fr"><input placeholder="商品名称/商品编号/订单编号" type="text" name="keywords"></div>
		        </form>
            </div>
			<div class="member-border">
				<div class="member-return H-over">
					<div class="member-cancel clearfix">
						<span class="be1">订单信息</span>
						<span class="be2">收货人</span>
						<span class="be2">订单金额</span>
						<span class="be2">订单时间</span>
						<span class="be2">订单状态</span>
					</div>
                    @foreach($data as $k => $v)
					<div class="member-sheet clearfix">
						<ul>
							<li>
								<div class="member-minute clearfix">
									<span>{{$v->addTime}}</span>
									<span>订单号：<em>{{$v->orderNo}}</em></span>
									<span><a href="#">{{$v->shopName}}</a></span>
									<span class="member-custom">客服电话：<em>{{$v->shopTel}}</em></span>
								</div>
								<div class="member-circle clearfix">
									<div class="ci1">
										<span class="gr1"><a href="#"><img src="{{URL::asset('/')}}{{$v->goodsImg}}" title="" about="" width="60" height="60"></a></span>
										<span class="gr2">
											<a href="{{url('order/goodContent')}}?id={{$v->orderId}}">
												{{$v->goodsName}}
											</a>
										</span>
										<span style="float:right;margin-top: 50px">X{{$v->goods_num}}</span>
									</div>
									<div class="ci2">
                                        {{$v->username}}
                                    </div>
									<div class="ci3">
                                        ￥{{$v->totalMoney}}
                                    </div>
									<div class="ci4">
                                        <p>{{$v->addTime}}</p>
                                    </div>
									<div class="ci5">
                                        <p>
                                            @if($v->orderStatus==-3) 用户拒收
                                               @elseif($v->orderStatus==-2)未付款
                                               @elseif($v->orderStatus==-1) 用户取消 
                                               @elseif($v->orderStatus==3) 待发货
                                               @elseif($v->orderStatus==1) 配送中
                                               @elseif($v->orderStatus==2) 用户确认收货
                                            @endif
                                        </p> 
                                        <p>
                                            <a href="{{url('order/orderContent')}}?id={{$v->orderId}}">
                                                订单详情
                                            </a>
                                        </p>
                                    </div>
								</div>
							</li>
						</ul>
					</div>
                    @endforeach
				</div>
				<div class="clearfix" style="padding:30px 20px;">
					{{$data->links()}}
				</div>

			</div>
		</div>
	</div>
</section>

@endsection