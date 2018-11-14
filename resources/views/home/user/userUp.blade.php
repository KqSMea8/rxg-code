@extends('home.left.left')
@section('left')
<!-- 会员 -->

		<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>密码修改</h2></div>
			</div>
			<div class="member-border">
				<div class="member-caution clearfix">
					<ul>
                    <form action="{{url('user/userUpdate')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$data[0]->userId}}">
						<li class="clearfix">
                        @foreach($data as $v)
					        <tr>
								<td>原始密码：</td>
								<td><input type="password" id="pass" name="password"></td>
								<span id="passts"></span>
							</tr>
                        </li>
                        <li class="clearfix">
                                <tr>
                                    <td>新的密码：</td>
                                    <td><input type="password" id="pwd" name="pwd"></td>
                                    <span id="pwdts"></span>
                                </tr>
                        </li>
                        <li class="clearfix">
								<tr>
									<td>确认密码：</td>
									<td><input type="password" id="passwd" name="passwd"></td>
									<span id="passwdts"></span>
								</tr>
                        </li>
                        <li class="clearfix">
                            <tr>
                                <td></td>
                                <td><input type="submit" id="sub" value="修改"></td>
                            </tr> 
						</li> 
                        @endforeach
                        </form>
					</ul>
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
<script>
	//修改密码的确认修改按钮的对应事件
 $("#sub").click(function(){
  var passwd = $("#passwd").val();
  var pwd1 = $("#pwd").val();
  var pass1 = $("#pass").val();
 
  if(pwd1 != passwd)  {
       $("#passwdts").html("您输入的新密码不一致！");
       return false;
  }  if(pwd1=="" && pass1=="")  {
       $("#passts").html("您输入的原始密码为空！");
       $("#pwdts").html("您输入的新密码为空！");
       return false;
  } else if(pwd1=="" || pass1=="" )  {
    if(pwd1=="") {
        $("#pwdts").html("您输入的新密码为空！");
        return false;
    } else if(pass1=="") {
        $("#passts").html("您输入的原始密码为空！");
        return false;
       }
    } else if(pwd1==pass1) {
        $("#pwdts").html("您输入的新密码与原始密码相同！");
        return false;
    } else if(pass() && pwd()) {
        return true;
    }  else  {
        return false;
    }

 
 });


</script>
@endsection