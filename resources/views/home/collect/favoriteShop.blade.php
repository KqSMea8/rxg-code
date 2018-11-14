@extends('home.left.left')
@section('left')
<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>我的收藏</h2></div>
				<div class="member-backs member-icons fr"><a href="#">搜索</a></div>
				<div class="member-about fr"><input placeholder="商品名称/商品编号/订单编号" type="text"></div>
			</div>
			<div class="member-switch clearfix">
				<ul id="H-table" class="H-table">
					<li><a href="{{URL::asset('collect/favoriteGoods')}}">我的收藏的商品</a></li>
					<li class="cur"><a href="{{URL::asset('collect/favoriteShop')}}">我收藏的店铺</a></li>
				</ul>
			</div>
			<div class="member-border">

				<div class="member-return H-over">
					<div class="member-troll clearfix">
						<div class="member-all fl"><b class="on"></b><span id="quan" isCheck="1">全选</span></div>
						<div class="member-check clearfix fl"> <a href="#" class="member-delete" id="btn">删除商品</a> </div>
					</div>
					<div class="member-vessel">
						<ul>
						@foreach($data as $k=>$v)
							<li class="clearfix">
								<div class="member-tenant fl clearfix">
									<div class="fl member-all1 member-all2"><b class="on"></b></div>
									<div class="fr">
										<a href="#"><input type="checkbox" value="{{$v['shopId']}}"><img src="{{URL::asset('/')}}{{$v['shopImg']}}" title="" width="114" height="114"></a>
										<p>{{$v['shopName']}}</p>
										<p><a href="#" class="member-shops">进入店铺</a> </p>
										<p>{{$v['shopQQ']}}</p>
									</div>
								</div>

								<div class="member-volume fl">
									<a href="#" class="fl member-btn-fl"></a>
									<div class="member-cakes fl">
										<ul>
										@foreach($v['goodsList'] as $key=>$val)
											<li>
												<a href="#"><input type="checkbox" value="{{$v['goodsId']}}"><img src="{{URL::asset('/')}}{{$val['goodsImg']}}" title="" width="125" height="125"></a>
												<p>{{$val['goodsName']}}</p>
												<p>￥{{$val['marketPrice']}}</p>
											</li>
										@endforeach
										</ul>
									</div>
									<a href="#" class="fr member-btn-fr"></a>
								</div>
							</li>
							@endforeach
							
						</ul>
					</div>
				</div>



				<div class="clearfix" style="padding:30px 20px;" id="pull_right">
    <div  style="float: right" class="pull-right">
{{$data->links()}}
</div>
</div>

			</div>
		</div>
<script>
		$(document).on('click',"#quan",function(){
			var xuan = $(this).attr('isCheck')
			var boxLength = $("input:checkbox").length
			var status = ''
			if (xuan==1) {
				status = true
				$(this).attr('isCheck',2)
				$(this).text('全不选')
			}else{
				status = false
				$(this).attr('isCheck',1)
				$(this).text('全选')
			}
			for (var i =0; i<boxLength;i++) {
				$("input:checkbox")[i].checked =status
			};
		})

		$(document).on('click',"#btn",function(ev){
			ev.preventDefault();
			var ids = []
			var suo = $("input:checked")
			$.each(suo,function(k,v){
				ids.push(v.value)
			})
			$.ajax({
				url:"{{url('collect/delFavoriteShops')}}",
				headers:{'X-CSRF-TOKEN':"{{csrf_token()}}"},
				type:'get',
				data:{ids:ids},
				dataType:'json',
				success:function(res){
					if (res.code==1) {
						location.href="{{url('collect/favoriteShop')}}"
					}
				}
			})
		})


</script>
@endsection