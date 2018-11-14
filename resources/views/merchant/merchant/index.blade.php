@extends('merchant.layout.default')
@section('content')
    <div class="container" style="margin-top: 2%;">
        <div style="margin-bottom: 1%">
            <span style="font-size: 16px;"><em>店铺信息</em></span>
            <span class="pull-right">
                        <a href="{{url('merchant/merchant/update')}}?id={{$data->shopId}}" class="btn btn-primary btn-xs">修改店铺信息</a>
            </span>
        </div>
        <table class="table-striped table table-bordered">
            <thead>
            <tr>
                <th>店铺编号</th>
                <th>店铺名称</th>
                <th>店铺图标</th>
                <th>店主</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$data->shopSn}}</td>
                    <td>{{$data->shopName}}</td>
                    <td><img src="{{URL::asset($data->shopImg)}}" width="35px;"></td>
                    <td>{{$data->shopkeeper}}</td>
                </tr>
            </tbody>
        </table>
        <div style="float:right">
        </div>
    </div>

@endsection