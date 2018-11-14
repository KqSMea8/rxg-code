@extends('home.left.left')
@section('left')
		<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>我的评价</h2></div>
			</div>
			<div class="member-border">
				<div class="member-column clearfix">
					<span class="co1">商品信息</span>
					<span class="co2">购买时间</span>
					<span class="co3">评价状态</span>
				</div>
				<div class="member-class clearfix">
					<ul>
					@foreach($goods as $k=>$v)
						<li class="clearfix">
							<div class="sp1">
								<span class="gr1"><a href="#"><img about="" title="" src="{{URL::asset('/')}}{{$v['goodsImg']}}" width="60" height="60"></a></span>
								<span class="gr2"><a href="#">{{$v['goodsName']}}</a></span>
								<span class="gr3">x1</span>
							</div>
							<div class="sp2">{{$v['addTime']}}</div>
							<div class="sp3">
						
							<a href="#" id="btn" goodsId="{{$v['goodsId']}}" shopId="{{$v['shopId']}}">发表评价</a>
							</div>
						</li>
					@endforeach
					</ul>
				</div>
				<div class="member-setup clearfix">
					<ul>
						<li class="clearfix">
							<div class="member-score fl"><i class="reds">*</i>评分：</div>
							<div class="member-star fl">
								<select name="" id="goodsScore">
								<option value="">选择评分</option>
									@for($i=60;$i<=100;$i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
							<div class="member-judge fr"><input type="checkbox" id="noname"> 匿名评价</div>
						</li>

						<li class="clearfix">
							<div class="member-score fl"><i class="reds">*</i>商品评价：</div>
							<div class="member-star fl">
								<textarea maxlength="200" id="content"></textarea>
							</div>
						</li>
						<li class="clearfix">
							<div class="member-score fl">晒单：</div>
							<div class="member-star fl">
								<form id="form" method="post" enctype="multipart/form-data" >
										{{csrf_field()}}
									<input type="file" name="images">
								</form>
						</li>
					</ul>
				</div>
				<div class="member-pages clearfix">
					<div class="fr pc-search-g">
						{{$goods->links()}}

					</div>
				</div>

			</div>
		</div>
	</div>
</section>
<script>
	$(document).on('click','#btn',function(e){
		e.preventDefault()
		var images = new FormData($("#form")[0]);
		var goodsId = $(this).attr('goodsId')
		var shopId = $(this).attr('shopId')
		var content = $('#content').val()
		var goodsScore = $('#goodsScore').val()
		var noname = $("#noname").prop('checked')
		$.ajax({
			url:"{{url('consult/add_evaluate_do')}}",
			headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
			data:{images:images,goodsId:goodsId,shopId:shopId,content:content,goodsScore:goodsScore,noname:noname},
			type:'post',
			dataType:'json',
			cache: false,
            processData: false,
            contentType: false,
			success:function(res){
				if (res.code==1) {
					layer.msg(res.message,{
						time:1000,
						icon:res.code
					})
				}else{
					layer.msg(res.message,{
						time:1000,
						icon:res.code
					})
				}
			}
		})

			
	})
</script>
@endsection
