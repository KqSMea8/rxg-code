@extends('merchant.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">订单管理</a></li>
        <li class="active">订单列表</li>
    </ol>
    <div class="container" style="width:100%;">
        <div style="margin-bottom: 1%;">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-12">
                <form action="{{URL::asset('merchant/order/order')}}" method="get" style="width: 100%" class="form-inline" id="form">
                    <select name="orderStatus" class="form-control" id="status">
                        <option class="dropdown-menu" value="">请选择订单状态</option>
                        <option value="-3" {{($orderStatus==-3)? 'selected' : ""}} >用户拒收</option>
                         <option value="-2" {{($orderStatus==-2)? 'selected' : ""}}>未付款</option>
                        <option value="-1" {{($orderStatus==-1)? 'selected' : ""}}>用户取消</option>
                        <option value="3" {{($orderStatus==3)? 'selected' : ""}}>待发货</option>
                        <option value="1" {{($orderStatus==1)? 'selected' : ""}}>配送中</option>
                        <option value="2" {{($orderStatus==2)? 'selected' : ""}}>确认收货</option>
                    </select>
                    <input class="btn btn-default" type="text" onClick="WdatePicker()" placeholder="开始日期" name="starttime" value="{{$starttime}}"> ~~
                    <input class="btn btn-default" type="text" onClick="WdatePicker()" placeholder="结束日期" name="endtime" value="{{$endtime}}">
                    <div class="input-group">
                        <input type="text" name="keywords" placeholder="订单编号/用户昵称" value="{{$keywords}}" id="search" class="form-control" style="width: 300px"/>
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">
                                <i class='glyphicon glyphicon-search'></i>搜索
                            </button>
                            <i class="glyphicon glyphicon-repeat"></i>
                            <button class="btn btn-success" type="reset">
                                <i class="glyphicon glyphicon-repeat"></i>重置
                            </button>
                        </span>
                    </div>
                </form>
                    </td>
                </tr>
            </table>
        </span>
        </div>
        <table class="table-hover table table-bordered">
            <thead>
            <tr class="active">
                <th>订单编号</th>
                <th>用户昵称</th>
                <th>订单状态</th>
                <th>订单原价</th>
                <th>实际支付</th>
                <th>支付方式</th>
                <th>是否付款</th>
                <th>下单时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orderdata as $k=>$v)
                <tr>
                    <td>{{$v->orderNo}}</td>
                    <td>{{$v->username}}</td>
                    <td>
                        @if($v->orderStatus == -3)
                            用户拒收
                        @elseif($v->orderStatus==-2)
                            <font color='red'>未付款</font>
                        @elseif($v->orderStatus==-1)
                            取消订单
                        @elseif($v->orderStatus==3)
                            待发货
                        @elseif($v->orderStatus==1)
                            配送中
                        @elseif($v->orderStatus==2)
                            确认收货
                        @endif
                    </td>
                    <td>￥{{$v->totalMoney}}</td>
                    <td>￥{{$v->realTotalMoney}}</td>
                    <td>
                        @if($v->payType == 0)
                            货到付款
                        @elseif($v->payType==1 && $v->orderStatus<>-2)
                            线上支付
                        @elseif($v->orderStatus==-2)
                            未付款
                        @endif
                    </td>
                    <td>
                        @if($v->isRefund == 0)
                            未退款
                        @elseif($v->isRefund==1)
                            已退款
                        @elseif($v->isRefund==2)
                            <a href="{{url('merchant/order/orderSales')}}?id={{$v->orderNo}}">退款审核</a>
                        @endif
                    </td>
                    <td>{{$v->addTime}}</td>
                    <td><a href="{{url('merchant/order/orderContent')}}?id={{$v->orderId}}" class="btn btn-primary btn-xs">查看详情</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right">
            {{$orderdata->links()}}
        </div>
    </div>
    <script>
        $(function () {
            var data = "{{session()->get('timeError')}}";
            if (data) {
                layer.msg(data, {
                    time: 2000,
                    icon: 2
                }, function () {
                    "{{session()->put('timeError','')}}"
                });
            }
        })
        $("#status").change(function () {
            $("#form").submit();
        });

        $("button[type='reset']").click(function () {
            $("#search").removeAttr("value");
            window.location.href = "order";

        });

        //判断时间


    </script>
@endsection