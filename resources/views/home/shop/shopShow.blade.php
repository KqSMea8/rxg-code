@extends('home.left.left')
@section('left')
<div class="center" style="background:#fff;">
	<div>
		<div class="containers"><div class="pc-nav-item"><a href="{{URL::asset('shop/shop')}}">推荐商品</a> &gt; <a href="">推荐商品列表</a></div></div>
		<div class="containers clearfix">
			<div class="fl">
				
				<div class="time-border-list pc-search-list clearfix">
					<ul class="clearfix">
						<li>
							<img src="{{URL::asset('/')}}{{$data['shopImg']}}" style="width:200px;height:200px;">
							<p class="head-name">
							<a href="#">{{$data['shopName']}}</a></p>
							<p><span class="price"><span style="color:black">店主:</span>{{$data['shopkeeper']}}</span></p>
							<p class="head-futi clearfix">
							<span class="fl" style="float:right">好评度：90% </span>
							<span class="fr"></span></p>
							<p class="clearfix">
							<a href="{{URL::asset('shop/addshopFavorites')}}?id={{$data['shopId']}}" class="fr pc-search-c">关注</a>
							</p>
						</li>
					</ul>
					
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection