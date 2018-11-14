@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">优惠券</a></li>
        <li><a href="{{url('admin/ticket/ticketList')}}">优惠券列表</a></li>
        <li class="active">优惠券修改</li>
    	</ol>
    <div class="container" style="margin-top: 2%;">
        <form action="{{url('admin/ticket/ticketAdddo')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
            	<input type="hidden" name="id" value="{{$ticketInfo->id}}">
                <tr>
                    <td class="col-lg-2 text-right">优惠券名称：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="优惠券名称" name="name" value="{{$ticketInfo->name}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">优惠金额：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="优惠金额" name="ticket_money" value="{{$ticketInfo->ticket_money}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">有效时间：</td>
                    <td class="col-lg-6 input-group-sm">
                          <input class="btn btn-default" type="text" onClick="WdatePicker()" placeholder="开始日期" name="start_Time" value="{{$ticketInfo->start_Time}}"> ~~
                    <input class="btn btn-default" type="text" onClick="WdatePicker()" placeholder="结束日期" name="end_Time" value="{{$ticketInfo->end_Time}}">
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">
                    </td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/ticket/ticketList')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回优惠券列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 修改优惠券
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
         $('button[id="submit"]').on('click',function (e) {
            e.preventDefault();
            var formData = $("#form").serialize();
            $.ajax({
                type: "post",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "{{url('admin/ticket/ticketEdit')}}" ,//url
                data: formData,
                success: function (res) {
                    if(parseInt(res.code)===2){
                        layer.msg(res.message, {
                            time: 1000,
                            icon: res.code
                        })
                    }else {
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        },function () {
                            location.href="{{url('admin/ticket/ticketList')}}";
                        });
                    }
                }
            })
        })
    </script>
@endsection