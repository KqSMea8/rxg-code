@extends('home.left.left')
@section('left')
<div class="center" style="background:#fff;">
	<div>
		<div class="containers"><div class="pc-nav-item"><a href="{{URL::asset('shop/goods')}}">推荐商品</a> &gt; <a href="">推荐商品列表</a></div></div>
		<div class="containers clearfix">
			<div class="fl">
				
				<div class="time-border-list pc-search-list clearfix">
					<ul class="clearfix">
					@foreach($data as $k=>$v)
						<li>
							<a href="{{url('goods/detail')}}?goodsId={{$v['goodsId']}}"> <img src="{{URL::asset('/')}}{{$v['goodsImg']}}" style="width:200px;height:200px;"></a>
							<p class="head-name">
							<a href="#">{{$v['goodsName']}}</a></p>
							<p><span class="price">￥{{$v['marketPrice']}}</span></p>
							<p class="head-futi clearfix">
							<span class="fl" style="float:right">好评度：90% </span>
							<span class="fr">{{$v['goodsDesc']}}</span></p>
							<p class="clearfix">
							<a href="{{URL::asset('shop/addGoodsFavorites')}}?id={{$v['goodsId']}}" class="fr pc-search-c">关注</a>
							</p>
						</li>
					@endforeach
					</ul>
					</div><span style="float:right">{{$data->links()}}</span>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection