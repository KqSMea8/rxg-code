@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">店铺管理</a></li>
        <li class="active">店铺列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-12">
                <form action="{{URL::asset('admin/store/storeList')}}" method="get" style="width: 100%;text-align: center" class="form-inline" id="form">
                    <select name="isSelf" class="form-control" onchange="changeSubmit()">
                                @foreach($isSelfArr as $k=>$v)
                            <option value="{{$k}}" {{($k==$isSelf)?'selected':''}}>{{$v}}</option>
                        @endforeach
                            </select>
                        <select name="shopStatus" class="form-control" onchange="changeSubmit()">
                                @foreach($shopStatusArr as $k=>$v)
                                <option value="{{$k}}" {{($k==$shopStatus)?'selected':''}}>{{$v}}</option>
                            @endforeach
                            </select>
                        <select name="isVerify" class="form-control" onchange="changeSubmit()">
                                <option value="3" {{($isVerify==3)?'selected':''}}>--是否审核--</option>
                            @foreach($isVerifyArr as $k=>$v)
                                <option value="{{$k}}" {{($isVerify==$k)?'selected':''}}>{{$v}}</option>
                            @endforeach
                            </select>
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="请输入店铺名称···" class="form-control" value="{{$shopName}}" style="width: 300px">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit"><i class='glyphicon glyphicon-search'></i>搜索</button>
                            <button class="btn btn-success" type="reset" onclick="resetForm()"><i class="glyphicon glyphicon-repeat"></i>重置</button>
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
                    <th>id</th>
                    <th>店铺编号</th>
                    <th>店铺图标</th>
                    <th>店铺名称</th>
                    <th>店主</th>
                    <th>是否自营</th>
                    <th>店铺状态</th>
                    <th>操作</th>
                    <th>审核操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $k=>$v)
                    <tr>
                        <td>{{$v->shopId}}</td>
                        <td>{{$v->shopSn}}</td>
                        <td><img src="{{URL::asset($v->shopImg)}}" height="50px"></td>
                        <td>{{$v->shopName}}</td>
                        <td>{{$v->userName}}</td>
                        <td>
                            @if($v->isSelf)
                                <span class="btn btn-primary btn-xs">自营</span>
                            @else
                                <span class="btn btn-danger btn-xs">非自营</span>
                            @endif
                        </td>
                        <td>
                            @if($v->shopStatus == 1)
                                <span class="btn btn-primary btn-xs">开业</span>
                            @else
                                <san class="btn btn-danger btn-xs">停业</san>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('admin/store/storeEdit')}}?shopId={{$v->shopId}}" class="btn btn-xs btn-primary">编辑</a>
                        </td>
                        <td class="col-md-1 input-group-sm">
                            <select id="isVerify" class="form-control" data-id="{{$v->shopId}}" style="width: 100px;">
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
            {{$data->links()}}
        </div>
    </div>
    <script>
        $("select#isVerify").on('change',function () {
            var thisO = $(this);
            var shopId = thisO.attr('data-id');
            var isVerify = thisO.val();
            $.ajax({
                url:"{{url('admin/store/updateVerify')}}",
                type:'GET',
                data:{shopId:shopId,isVerify:isVerify},
                success:function (res) {
                    layer.msg(res.message,{
                        time:1000,
                        icon:res.code
                    },function () {
                        history.go(0)
                    })
                }
            })
        });
        function changeSubmit() {
            $("#form").submit();
        }
        function resetForm() {
            location.href="{{url('admin/store/storeList')}}";
        }
    </script>
@endsection