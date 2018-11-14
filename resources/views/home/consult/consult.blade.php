@extends('home.left.left')
@section('left')
		<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>商城快讯</h2></div>
			</div>
			<div class="member-border">
				<div class="member-form clearfix">
					<form action="{{url('consult/consult')}}">
						<input class="text-news" name="uname" placeholder="商城快讯关键字" type="text" value="{{$name}}">
						<input class="button-btn" value="搜索" type="submit">
					</form>
				</div>
				<div class="member-entry">
					<div class="member-issue clearfix">
						<span style="width:30%">标题</span>
						<span style="width:30%">发布时间</span>
						<span style="width:30%">结束时间</span>
					</div>
					@foreach($data as $v)
					<ul>
						<li class="clearfix">
							<div style="width:30%"><a href="#">{{$v->activityName}}</a></div>
							<div style="width:30%">{{$v->sTime}}</div>
							<div style="width:30%">{{$v->oTime}}</div>
						</li>
					</ul>
					@endforeach
				</div>
				<div class="member-pages clearfix">
						{{$data->links()}}
				</div>
			</div>
		</div>
	</div>
</section>

@endsection