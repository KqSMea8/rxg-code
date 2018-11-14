@extends('home.left.left')
@section('left')
<!-- 会员 -->
		<div class="member-right fr">
			<div class="member-head">
				<div class="member-heels fl"><h2>手机号修改</h2></div>
			</div>
			<div class="member-border">
				<div class="member-caution clearfix">
					<ul>
					<!-- action="{{url('user/userUpdate')}}" -->
                    <form  method="post" id="form">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$data[0]->userId}}">
						<li class="clearfix">
                        @foreach($data as $v)
					        <tr>
								<td>原始手机号：</td>
								<td>
									<input type="text" id="tel" name="tel" onblur="te()">
									<span id="tell"></span>
								</td>
							</tr>
                        </li>
                        <li class="clearfix">
                            <tr>
                                <td>新的手机号：</td>
                                <td>
                                	<input type="text" id="phone" name="phone" onblur="telu()">
                                	<span id="phon"></span>
                                </td>
                            </tr>
                        </li>
                        <li class="clearfix">
                            <tr>
                                <td></td>
                                <td>
                                	<input type="submit" value="修改" id="sub" onclick="su()">
                                	<!-- <button type="submit" value="">修改</button> -->
                                </td>
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
	function te() {
            var myreg=/^1[3,4,5,7,8]\d{9}$/;
            var tel = $('#tel').val();
            if(!myreg.test(tel)){
	    		$('#tell').html('<font color="red">手机号格式不正确！！</font>');
	    		return false; 
	    	} else {
	    		$('#tell').html('<font color="cyan">√</font>');
	    		return true;
	    	}
        }

    function telu() {
            var phone = $('#phone').val();
            if(phone==''){
	    		$('#phon').html('<font color="red">请输入手机号！！</font>');
	    		return false; 
	    	} else {
	    		$('#phon').html('<font color="cyan">√</font>');
	    		return true;
	    	}
        }

    function su() {
            var tel = $('#tel').val();
			var phone = $('#phone').val();
			var myreg=/^1[3,4,5,7,8]\d{9}$/;
		    if (tel==phone) {
		    	$('#phon').html('<font color="red">输入的手机号不能与之前的一样！！</font>');
		    	return false;
		    } else if(!myreg.test(phone)) {
		    	$('#phon').html('<font color="red">手机号格式不正确！！</font>');
	    		return false; 
	    	} else{
				$('#phon').html('<font color="cyan">√</font>');
				return true;

			}
        }
        $("#sub").on('click',function (e){
		// alert(1);return
	    e.preventDefault();
	    if(su()){
	    	var data = new FormData($("#form")[0]); 
	    // alert(data);return
		$.ajax({
        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
        url:"{{url('user/telUp')}}",
        dataType:'json',
        type:'post',
        data:data,
        cache: false,
        processData: false,
        contentType: false,
        // alert(data);return
        success:function (res) {
            if(res.code == 1){
                layer.msg(res.message,{
                    time:1000,
                    icon:res.code,
                },function () {
                    window.location.href="{{url('user/user')}}";
                });
            }else{
                layer.msg(res.message,{
                    time:1000,
                    icon:res.code
                });
            }

        }
        })
	}
    
})
	
</script>
@endsection
