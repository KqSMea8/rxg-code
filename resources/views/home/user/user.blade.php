@extends('home.left.left')
@section('left')
<section id="member">
	<div class="member-center clearfix">
		<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>账户安全</h2></div>
			</div>
			<div class="member-border">
				<div class="member-caution clearfix">
				@foreach($data as $v)
					<ul>
						<li class="clearfix">
							<div class="warn1"></div>
							<div class="warn2">登录密码</div>
							<div class="warn3">互联网账号存在被盗风险，建议您定期更改密码以保护账户安全。</div>
							<div class="warn5">
								<a href="userUp?id={{$v->userId}}">修改密码</a>
							</div>
						</li>
						<li class="clearfix">
							<div class="warn1"></div>
							<div class="warn2">手机号</div>
							<div class="warn3">您验证的手机：
								<i class="reds">{{$v->tel}}</i>  若已丢失或停用，请立即更换，<i class="reds">避免账户被盗</i></div>
							<div class="warn5">
								<a href="userTel?id={{$v->userId}}">修改手机号</a>
							</div>
						</li>
					</ul>
					@endforeach
					<div class="member-prompt">
						<p>安全提示：</p>
						<!-- <p>您当前IP地址是：<i class="reds">110.106.0.01</i>  北京市          上次登录的TP： 2015-09-16  <i class="reds">110.106.0.02 </i> 天津市</p> -->
						<p>1. 注意防范进入钓鱼网站，不要轻信各种即时通讯工具发送的商品或支付链接，谨防网购诈骗。</p>
						<p>2. 建议您安装杀毒软件，并定期更新操作系统等软件补丁，确保账户及交易安全。      </p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection