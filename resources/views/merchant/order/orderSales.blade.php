@extends('merchant.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="{{url('merchant/order/order')}}">订单管理</a></li>
        <li><a href="{{url('merchant/order/order')}}">订单列表</a></li>
        <li>退款管理</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <div class="page-title" style="margin-bottom: 1%"></div>
        <form action="{{url('merchant/order/orderUp')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
            <input type="hidden" name="orderId" value="{{$data->orderId}}">
                <tr>
                    <td class="col-lg-2 text-right">申请原因：</td>
                    <td class="col-lg-6 input-group-sm">
                        {{$data->cancelReason}}
                    </td>
                </tr>
                @if($data->remark!='')
                <tr>
                    <td class="col-lg-2 text-right">备注：</td>
                    <td class="col-lg-6 input-group-sm">
                        {{$data->remark}}
                    </td>
                </tr>
                @endif
                <tr>
                    <td class="col-lg-2 text-right">
                    </td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('merchant/order/order')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回订单列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 确认退款
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
                url: "{{url('merchant/order/orderUp')}}" ,//url
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
                            location.href="{{url('merchant/order/order')}}";
                        });
                    }
                }
            })
        })
    </script>
@endsection