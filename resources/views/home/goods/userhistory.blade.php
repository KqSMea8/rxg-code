@extends('home.left.left')
@section('left')
<script src="{{URL::asset('js/jquery1.7.2.min.js')}}"></script>
<!-- 收藏 -->
<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>我的足迹</h2></div>
				<div class="member-backs member-icons fr"><!-- <a href="#" id="sou">搜索</a> --></div>
				<div class="member-about fr"><!-- <input placeholder="商品名称/商品编号/订单编号" type="text" id="keyword"> --></div>
			</div>
			
			<div class="member-border">

				<div class="member-return H-over">
					<div class="member-troll clearfix">
						<div class="member-all fl"><b class="on"></b><span id="quan" isCheck='1'>全选</span></div>
						<div class="member-check clearfix fl"> <a href="#" class="member-delete" id="btn">删除商品</a> </div>
					</div>
					<div class="member-vessel">
						<ul>
							<li class="clearfix">
								<div class="member-volume fl" style="width:967px;">
									<a href="#" class="fl member-btn-fl"></a>
									<div class="member-cakes fl" id="box">
										<ul>
						@foreach($data as $k=>$v)
											<li>
											<input type="checkbox" value="{{$v['goodsId']}}">
												<a href="{{url('goods/detail')}}?goodsId={{$v['goodsId']}}"><img src="{{URL::asset('/')}}{{$v['goodsImg']}}" title="" width="125" height="125"></a>
												<p>{{$v['goodsName']}}</p>
												<p>￥{{$v['marketPrice']}}</p>
											</li>
											
							@endforeach
										</ul>
									</div>
									<a href="#" class="fr member-btn-fr"></a>
								</div>
							</li>
										</ul>
				
									</div>
									<a href="#" class="fr member-btn-fr"></a>
								</div>
							</li>
						</ul>
					<div class="clearfix" style="padding:30px 20px;" id="pull_right">
    <div  style="float: right" class="pull-right">
	{{$data->links()}}
</div>
</div>
					</div>
						
				</div>
			</div>
		</div>
<script>
	$(document).on('click',"#btn",function(e){
		e.preventDefault()
		var ids = []
		var suo = $("input:checked")
		$.each(suo,function(k,v){
			ids.push(v.value)
		})
		$.ajax({
			url:"{{url('goods/delHistory')}}",
			headers:{'X-CSRF-TOKEN':"{{csrf_token()}}"},
			type:'get',
			data:{ids:ids},
			dataType:'json',
			success:function(res){
				if (res.code==1) {
					location.href="{{url('goods/userHistory')}}";
				}
			}
		})
	})

	$(document).on("click","#quan",function(){
		var xuan = $(this).attr('isCheck')
		var boxLength = $("input:checkbox").length
		var status = ''
		if (xuan==1) {
			status = true
			$(this).attr('isCheck',2);
			$("#quan").text('全不选');
		}else{
			status = false
			$(this).attr('isCheck',1)
			$("#quan").text('全选')
		}
		for (var i =0; i < boxLength; i++) {
			$("input:checkbox")[i].checked = status
		};
	})

	$(document).on('click','#sou',function(e){
		e.preventDefault()
		var goodsName = $("#keyword").val()
		$.ajax({
			url:"{{url('goods/userHistory')}}",
			headres:{'X-CSRF-token':"{{csrf_token()}}"},
			data:{goodsName:goodsName},
			dataType:'json',
			success:function(res){
				if (res) {
					$("#box ul li").remove()
					var du = res.data.length
					for (var i=0;i<du;i++) {
					var li = $("<li></li>")
					li.append("<input type='checkbox' value='"+res.data[i].goodsId+"'>")
					li.append("<img src='{{URL::asset('/')}}"+res.data[i].goodsImg+"' title=' width='125' height='125'>")
					li.append("<p>"+res.data[i].goodsName+"</p>")
					li.append("<p>￥"+res.data[i].marketPrice+"</p>")
					$("#box ul").append(li);
					}


				}
			}
		})
	})
</script>
@endsection