@extends('admin.layout.default')
@section('content')
	<style>
		table tr td {
			padding-top: 10px;
			padding-bottom: 10px;
			width: 800px;

		}
		table tr td textarea {
	        width:950px;
	        height:100px;
    	}
	</style>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.js"></script>

    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">广告管理</a></li>
        <li><a href="{{url('admin/advertising/advertisingList')}}">广告列表</a></li>
        <li class="active">广告添加</li>
    </ol>


  <form id="form" method="post" enctype="multipart/form-data" >
{{csrf_field()}}
  <table>
	
	<tr>
		<td class="col-lg-2 text-right">广告名称:</td>
		<td class="col-lg-6 input-group-sm">
			<input type="text" name="uname" class="form-control" />
			 <!-- required="required" -->
		</td>
	</tr>
	<tr>
		<td class="col-lg-2 text-right">广告投放位置:</td>
		<td class="col-lg-6 input-group-sm">
			<select name="place" class="form-control">
				<option value="1">轮播图右侧边栏</option>
				<option value="2">具体根据客户需求吧</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="col-lg-2 text-right">省份:</td>
		<td class="col-lg-6 input-group-sm">
			<select name="province" class="form-control">
			@foreach($data as $v)
				<option value="{{$v->id}}">{{$v->province}}</option>
			@endforeach
			</select>
		</td>
	</tr>
    <tr>
        <td class="col-lg-2 text-right">时间设置:</td>
        <td class="col-lg-6 input-group-sm">
            <input type="text" id="config-demo" name='time' class="form-control">
        </td>
    </tr>
	<tr>
		<td class="col-lg-2 text-right">媒介类型:</td>
		<td class="col-lg-6 input-group-sm">
			<select name="type" class="form-control" id="type" onchange="dian()">
				<option value="">请选择</option>
				<option value="1">图片</option>
				<option value="2">文字</option>
			</select>
		</td>
   </tr>
   <tr id="im" style="display:none">
		<td class="col-lg-2 text-right">上传图片</td>
		<td class="col-lg-6 input-group-sm">
			{{--img src="{{URL::asset('img/up.png')}}" id="img" title="添加图片" style="border:1px solid #d2d6de; max-width: 120px;"/>--}}
			<input name="img" id="img" type="file" accept="image/*" class="textBox" />
		</td>
   </tr>
   <tr id="deta" style="display:none">
		<td class="col-lg-2 text-right">输入广告内容</td>
		<td class="col-lg-6 input-group-sm">
			<textarea  name="details"  class="textBox"></textarea>
			<!-- required="required" -->
		</td>
   </tr>
   <tr>
		<td class="col-lg-2 text-right"></td>
		<td class="col-lg-4 input-group-sm text-center">
			<a href="{{url('admin/advertising/advertisingList')}}" class="btn btn-warning" style="width:150px">
				<i class="glyphicon glyphicon-hand-left"></i>返回广告列表</a>
			<button type="submit" id="submit" class="btn" style="background-color: #4fd98b;width: 150px">
				<i class='glyphicon glyphicon-plus'>添加</i>
			</button>
		</td>
   </tr>
</table>
</form>
</div>
<script>

	function dian() { 
        var sel=document.getElementById("type"); 
        if (sel.value=="1") { 
        	var sum2=document.getElementById("deta");//隐藏输入框2
            sum2.style.display="none"; 
            var sum2=document.getElementById("im");//显示输入框1
            sum2.style="float:right".display="block"; 
        } else if (sel.value=="2") {
            var sum1=document.getElementById("deta");//显示输入框2
            sum1.style="float:right".display="block";
            var sum2=document.getElementById("im");//隐藏输入框1
            sum2.style.display="none"; 
        }
        
    }


 $("button[type='submit']").on('click',function (e){
            e.preventDefault();
            var data = new FormData($("#form")[0]);
			$.ajax({
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                url:"{{url('admin/advertising/advertisingAdd')}}",
                dataType:'json',
                type:'post',
                data:data,
                cache: false,
                processData: false,
                contentType: false,
                success:function (res) {
                    if(res.code == 1){
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code,
                        },function () {
                            window.location.href="{{url('admin/advertising/advertisingList')}}";
                        });
                    }else{
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        });
                    }

                }
            })
    })
 //时间
 var beginTimeTake;
            
    $('#config-demo').daterangepicker({
        singleDatePicker: false,
        showDropdowns: true,
        autoUpdateInput: true,
        timePicker24Hour : true,
        timePicker : true,
        "locale": {
            format: 'YYYY-MM-DD HH:mm',
            applyLabel: "应用",
            cancelLabel: "取消",
            resetLabel: "重置",
        }
    }, 
    function(sTime, oTime, label) {
        beginTimeTake = sTime;
        if(!this.sTimeDate){
            this.element.val('');
        }else{
            this.element.val(this.sTimeDate.format(this.locale.format));
        }
    });
</script>
@endsection