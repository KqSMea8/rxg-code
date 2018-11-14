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
        <li class="active">广告修改</li>
    </ol>

  <form id="form" method="post" enctype="multipart/form-data" >
{{csrf_field()}}

  <table>
  <input type="hidden" name="id"  value="{{$data[0]->aid}}" />
  <input type="hidden" name="image" id="image" value="{{$data[0]->img}}
  ">
    <tr>
        <td class="col-lg-2 text-right">广告名称:</td>
        <td class="col-lg-6 input-group-sm">
            <input type="text" name="uname" class="form-control"  value="{{$data[0]->uname}}" />
            <!-- required="required" -->
        </td>
    </tr>
    <tr>
        <td class="col-lg-2 text-right">广告投放位置:</td>
        <td class="col-lg-6 input-group-sm">
            <select class="form-control" name="place">
                <option value="1" {{($data[0]->place)==1?'selected':''}}>轮播图右侧边栏</option>
                <option value="2" {{($data[0]->place)==3?'selected':''}}>具体根据客户需求吧</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="col-lg-2 text-right">省份:</td>
        <td class="col-lg-6 input-group-sm">
            <select class="form-control" name="province">
                @foreach($arr as $v)
                        <option value="{{$v->id}}" {{($data[0]->province)==$v->id?'selected':''}}>{{$v->province}}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td class="col-lg-2 text-right">时间设置:</td>
        <td class="col-lg-6 input-group-sm">
            <input type="text" id="config-demo" name='time' class="form-control" value="{{$data[0]->time}}">
        </td>
    </tr>
    <tr>
        <td class="col-lg-2 text-right">媒介类型:</td>
        <td class="col-lg-6 input-group-sm">
            <select class="form-control" id="type" name="type" onchange="dian()" >
                <option value="1" {{($data[0]->type)==1?'selected':''}}>图片</option>
                <option value="2" {{($data[0]->type)==2?'selected':''}}>文字</option>
            </select>
        </td>
    </tr>
    <!-- style="display:none" -->
    <tr  id="im" style="display:none">
        <td class="col-lg-2 text-right">上传图片</td>
        <td class="col-lg-6 input-group-sm">
            {{--img src="{{URL::asset('img/up.png')}}" id="img" title="添加图片" style="border:1px solid #d2d6de; max-width: 120px;"/>--}}
            <input name="img" id="img" type="file" accept="image/*" class="textBox" />
            
            <img src="{{URL::asset('')}}{{$data[0]->img}}"  width="60" height="60" >
        </td>
    </tr>
    <!-- style="display:none" -->
    <tr style="display:none" id="deta">
    <div>
        <td class="col-lg-2 text-right">输入广告内容</td>
        <td class="col-lg-6 input-group-sm">
            <textarea  width="100" height="200" name="details" >{{$data[0]->details}}</textarea>
        </td></div>
    </tr>
    <tr>
        <td class="col-lg-2 text-right"></td>
        <td class="col-lg-4 input-group-sm text-center">
            <a href="{{url('admin/advertising/advertisingList')}}" class="btn btn-warning" style="width:150px">
                <i class="glyphicon glyphicon-hand-left"></i>返回广告列表</a>
            <button type="submit" id="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                <i class='glyphicon glyphicon-plus'>修改</i>
            </button>
        </td>
    </tr>
  </table>
  </form>
</body>
</html>
<script>
    $(function(){
        var sel=document.getElementById("type"); 
            if (sel.value=="1") { 
                var sum1=document.getElementById("deta");//显示输入框2 
                sum1.style.display="none"; 
                var sum2=document.getElementById("im");//显示输入框1
                sum2.style="float:right".display="block"; 
            } else if (sel.value=="2") {
                var sum1=document.getElementById("deta");//隐藏输入框1 
                sum1.style="float:right".display="block";
                var sum2=document.getElementById("im");//显示输入框2 
                sum2.style.display="none"; 
            }
    })
    function dian() { 
        var sel=document.getElementById("type"); 
        if (sel.value=="1") { 
            var sum1=document.getElementById("deta");//显示输入框2 
            sum1.style.display="none"; 
            var sum2=document.getElementById("im");//显示输入框1
            sum2.style="float:right".display="block"; 
        } else if (sel.value=="2") {
            var sum1=document.getElementById("deta");//隐藏输入框1 
            sum1.style="float:right".display="block";
            var sum2=document.getElementById("im");//显示输入框2 
            sum2.style.display="none"; 
        }
        
    }


//表单
$("button[type='submit']").on('click',function (e){
    e.preventDefault();
    var data = new FormData($("#form")[0]);
    $.ajax({
        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
        url:"{{url('admin/advertising/advertisingUpdate')}}",
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