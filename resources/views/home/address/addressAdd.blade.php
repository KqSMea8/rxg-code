@extends('home.left.left')
@section('left')
<script src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
<style>
    #one{
        font-size: 15px;
        color:#38b0DE;
        margin-left: 17px;
    }
    #two{
        font-size: 15px;
        margin-left: 20px;
    }
    #form table tr td span{
        color:red;
    }
    #three{
        margin-top: 20px;
        font-size: 15px;
        border-collapse: separate; 
        border-spacing: 15px; 
    }
    #three input{
        line-height: 20px;
    }
    #list{
        margin-top: 20px;
    }
    #list table{
        width: 100%;
        border-collapse: separate; 
        border-spacing: 15px; 
        font-size: 15px;
    }
    #lists{
        background-color: #CDCDCD;
        line-height: 30px;
    }
</style>
<!-- 收货地址 -->
<div class="member-right fr">
            <div class="member-head" style="background-color: rgba(0,0,0,0);;">
    <div class="member-heels fl"><h2 style="margin-top: 2px;color: #000;">收货地址</h2></div>
            </div>
            <div class="member-switch clearfix" id='cc'>
                <span id='one'>新增收货地址</span>
                <span id='two'>所有内容必填</span>
            </div>
            <div>
            <form action="" id='form' method="post">
                {{csrf_field()}}
                <center>
                    <table id ='three'> 
                        <input type="hidden" value="{{$user[0]->userId}}" name="user_id" />
 
                        <tr>
                            <td align='right'><span>*</span>地址信息:</td>
                            <td>
                                <select name="province" id="provinces" class="select-1">
                                    <option>请选择市</option>
                                    @foreach($area as $k => $v)
                                    <option value="{{$v->id}}" id="provinces">{{$v->areaName}}</option>
                                    @endforeach
                                </select>
                                <select name="city" id="city" class="select-2">
                                    <option>城市/地区/自治州</option>
                                </select>
                                <select name="distruct" id="distruct" class="select-3">
                                    <option>区/县</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><span>*</span>详细地址:</td>
                            <td>
                                <textarea id='text' name='street' placeholder="请输入详细地址信息,如道路、小区、楼栋号、单元等信息" style="huerreson:expression(this.width=this.scrollWidth);width:348px;height:40px"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><span>*</span>邮政编码:</td>
                            <td>
                                <input type="text" name='email' placeholder="如您不清楚邮递区号,请填写000000" id='email' onblur="emai()" style="width:348px">
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><span>*</span>收货人姓名:</td>
                            <td>
                                <input type="text" name='user_name' placeholder="长度不超过25个字符" id='userName' onblur='user()' style="width:348px">
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><span>*</span>手机号码:</td>
                            <td>
                                <select name="" id="">
                                    <option value="">中国大陆+86</option>
                                </select>
                                <input type="text" name='tell' placeholder="电话号码必须填" id='tell' onblur='te()' style="width:233px">
                            </td>
                        </tr>
                        <tr>
                            <td align='right'></td>
                            <td>
                                <button id="submit" type="submit" value='保存' class="btn btn-danger btn-xs">保存</button>
                            </td>
                        </tr>
                    </table>
                </center>
            </form>
        </div>
        <div id='list'>
            <center>
                <table>
                    <tr id='lists' align="center">
                        <td>收件人</td>
                        <td>所在地区</td>
                        <td>详细地址</td>
                        <td>邮箱</td>
                        <td>电话</td>
                        <td>操作</td>
                        <td></td>
                    </tr>
                    @foreach($address as $k => $v)
                    <tr align='center'>
                        <td>{{$v->user_name}}</td>
                        <td>
                            {{$v->provinceName}}
                            {{$v->cityName}}
                            {{$v->distructName}}
                        </td>
                        <td>{{$v->street}}</td>
                        <td>{{$v->email}}</td>
                        <td>{{$v->tell}}</td>
                        <td>
                            <a href="up?id={{$v->id}}" title="编辑">编辑</a>
                            <a title="删除" href="javascript:void(0)"  onclick="addressDel({{$v->id}})">删除</a>
                        </td>
                        <td >
                            <span onclick="item({{$v->id}})" class="item" id="item{{$v->id}}" data-id="{{$v->id}}" style="{{$user[0]->address_id==$v->id  ? 'background-color:#38b0DE' : '' }}">默认地址</span>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </center>
        </div>
</div>
<script type="text/javascript">
    $("#provinces").change(function(){
        $('#city').empty();
        var id = $(this).val();
        $.ajax({
            url:"{{url('address/city')}}",
            data:{id:id},
            success:function(res){
                $('#city').append("<option value='请选择市'>请选择城市</option>");
                $(res.data).each(function(k,v){
                    $('#city').append("<option value="+v.id+">"+v.areaName+"</option>");
                })
            }
        })
    })
    $("#city").change(function(){
        $("#distruct").empty();
        var value=$(this).val();
          $.ajax({
            url:"{{url('address/distruct')}}",
            data:{value:value},
            success:function(res){
                $('#distruct').append("<option value='请选择县'>请选择城县</option>");
                $(res.data).each(function(k,v){
                    console.log(v);
                    $("#distruct").append("<option value="+v.id+">"+v.areaName+"</option>");
                })
            }
        })
    })

    //手机号验证
    function te(){
        var tell = $("[name='tell']").val();
        if (tell === '') {
            layer.tips('手机号不能为空',"[name='tell']",{
                tips:[1,"#f00"],
                time:1000
            });
            return false;
        }else if (/^1[3,4,5,7,8]\d{9}$/.test(tell)) {
            return true;
        }else{
            layer.tips("手机号格式不正确","[name='tell']",{
                tipe:[1,'#f00'],
                time:1000
            });
            return false;
        }
    }
    //邮箱验证
    function emai(){
        var email = $("[name='email']").val();
        if (email === '') {
            layer.tips('邮箱不能为空',"[name='email']",{
                tips:[1,"#f00"],
                time:1000
            });
            return false;
        }else if (/^[0-9][0-9]{5}$/.test(email)) {
            return true;
        }else{
            layer.tips("邮箱格式不正确","[name='email']",{
                tipe:[1,'#f00'],
                time:1000
            });
            return false;
        }
    }
    //用户名验证
    function user(){
        var user_name = $("[name='user_name']").val();
        if (user_name === '') {
            layer.tips('用户名不能为空',"[name='user_name']",{
                tips:[1,"#f00"],
                time:1000
            });
            return false;
        }else if (/^[\u4E00-\u9FA5]{1,25}$/.test(user_name)) {
            return true;
        }else{
            layer.tips("用户名格式不正确","[name='user_name']",{
                tipe:[1,'#f00'],
                time:1000
            });
            return false;
        }
    }


    //表单验证
    $("button[type = 'submit']").on('click',function (e){
        e.preventDefault();
        var data = new FormData($("#form")[0]);
        // alert(data);return
        $.ajax({
            url:"{{url('address/addressDo')}}",
            headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
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
                            icon:res.code
                        },function () {
                            window.location.href="{{url('address/addressAdd')}}";
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
    //删除
    function addressDel(id){

            layer.msg('您确定要删除吗？',{
                icon: 3
                ,btn:['是','否']
                ,btn1:function(){
                    $.ajax({
                        url:"{{url('address/addressDel')}}",
                        data:{id:id},
                        type:'GET',
                        dataType:"json",
                        success:function(res){
                            if (res.con===1) {
                                layer.msg('删除失败',{
                                    time:1000,
                                    icon:2
                                })
                            }else{
                                layer.msg('删除成功',{
                                    time:1000,
                                    icon:1
                                })
                            }
                            history.go(0)
                        }
                    })
                }
            })
        }
        //点击事件
        function item(id){
            $('span.item').each(function(k,v){
                $(v).attr("style","");
            })
            var item = $("#item"+id).attr("data-id");
            $("#item"+id).css("background-color","#38b0DE");
            $.ajax({
                url:"{{url('address/addressUpdateId')}}",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                dataType:'json',
                type:'post',
                data:{address_id:item},
                success:function(){

                }
            })
        }
</script>
@endsection