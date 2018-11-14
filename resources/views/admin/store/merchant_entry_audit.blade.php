@extends('admin.layout.default')
@section('content')
    <div class="container" style="margin-top: 2%;">
        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><i></i><em>店铺入驻审核</em></span>
        </div>
        <table class="table-striped table table-bordered">
            <thead>
            <tr>
                <th>id</th>
                <th>店铺编号</th>
                <th>店铺图标</th>
                <th>店铺名称</th>
                <th>店主</th>
                <th>店铺地址</th>
                <th>是否自营</th>
                <th>审核操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$v)
                <tr>
                    <td>{{$v->shopId}}</td>
                    <td>{{$v->shopSn}}</td>
                    <td>{{$v->shopImg}}</td>
                    <td>{{$v->shopName}}</td>
                    <td>{{$v->userName}}</td>
                    <td>{{$v->shopAddress}}</td>
                    <td>
                        @if($v->isSelf)
                            <span class="btn btn-primary btn-xs">自营</span>
                        @else
                            <span class="btn btn-danger btn-xs">非自营</span>
                        @endif
                    </td>
                    <td class="col-md-2 input-group-sm">
                        <select name="isVerify" class="form-control">
                            @foreach($isVerifyArr as $key=>$val)
                                <option value="{{$key}}" {{($key==$v->isVerify)?'selected':''}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right">
            {{--{{$data->links()}}--}}
        </div>
        <!-- BatchOperation -->
    </div>
@endsection