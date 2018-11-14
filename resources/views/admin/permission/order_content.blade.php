@extends('admin.layout.default')
@section('content')
<ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">订单管理</a></li>
        <li class="active"><a href="{{url('admin/order/orderList')}}">订单列表</a></li>
        <li class="active">订单详情</li>
    </ol>
<div class="container" style="margin-top: 2%;">
<!--        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><i></i><em><a href="{{url('admin/order/orderList')}}"><<<订单列表</a></em></span>
        </div>-->
        
       
        <table class="table-striped table table-bordered" style="margin-top: 25px">
            <thead>
            <tr>
                <th>订单编号</th>
                <th>所属店铺</th>
                <th>用户昵称</th>
                <th>用户手机号</th>
                <th>是否支付</th>
                <th>实际支付</th>
                <th>支付来源</th>
                <th>订单备注</th>
                <th>是否退款</th>
                <th>是否评价</th>
                
            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$v)
                <tr>
                    <td>{{$v->orderNo}}</td>
                    <td>{{$v->shopName}}</td>
                    <td>{{$v->username}}</td>
                    <td>{{$v->userPhone}}</td>
                    <td>
                        @if($v->isPay==0 || $v->orderStatus==-2)
                        <font color='red'>未支付</font>
                        @elseif($v->isPay==1)
                        已支付
                        @endif
                        
                    </td>
                    
                    <td>{{$v->realTotalMoney}}</td>
                    <td>
                        @if($v->payFrom==1 && $v->orderStatus<>-2)
                        <font color='blue'>支付宝</font>
                        @elseif($v->payFrom==2 && $v->orderStatus<>-2)
                        <font color='green'>微信</font>
                        @endif
                    </td>
                    <td>{{$v->orderRemarks}}</td>
                    <td>
                       
                        
                        @if($v->isRefund==0)
                        未退款
                        @elseif($v->isRefund==1)
                        已退款
                        @endif
                        
                    </td>
                    <td>
                        
                        @if($v->isAppraise==0)
                        未评价
                        @elseif($v->orderStatus=2 && $v->isAppraise==1)
                        已评价
                        @endif
                    
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
    </div>
@endsection
