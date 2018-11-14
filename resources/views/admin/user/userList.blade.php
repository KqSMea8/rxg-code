@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">用户管理</a></li>
        <li class="active">用户列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('admin/user/userList')}}" method="get" style="width: 100%"
                      class="form-inline">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="请输入姓名或者电话号···" class="form-control"
                               value="{{$keyword}}" style="width: 300px">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">
                                <i class='glyphicon glyphicon-search'></i>搜索
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
                <th>用户id</th>
                <th>用户名称</th>
                <th>性别</th>
                <th>QQ</th>
                <th>微信</th>
                <th>用户电话</th>
                <th>用户邮箱</th>
                <th>真实姓名</th>
                <th>用户头像</th>
                <th>用户类型</th>
                <th>用户最后登录的ip地址</th>
                <th>用户状态</th>
                <th>注册日期</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v->userId}}</td>
                    <td>{{$v->username}}</td>
                    <td>
                        @if($v->sex==1)
                            <font color="green">男</font>
                        @else
                            <font color="red">女</font>
                        @endif
                    </td>
                    <td>{{$v->qq}}</td>
                    <td>{{$v->weixin}}</td>
                    <td>{{$v->tel}}</td>
                    <td>{{$v->email}}</td>
                    <td>{{$v->trueName}}</td>
                    <td>{{$v->userPhoto}}</td>
                    <td>
                        @if($v->type==1)
                            <font color="green">普通用户</font>
                        @else
                            <font color="red">店铺用户</font>
                        @endif
                    </td>
                    <td>{{$v->lastIp}}</td>
                    <td>
                        @if($v->status == 0)
                            <a href="javascript:;" title="正常" onclick="changeIsShow({{$v->userId}},1)"
                               class="btn btn-primary btn-xs">正常</a>
                        @else
                            <a href="javascript:;" title="冻结" onclick="changeIsShow({{$v->userId}},0)"
                               class="btn btn-primary btn-xs">冻结</a>
                        @endif
                    </td>
                    <td>{{$v->regTime}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right">
        {{$data->links()}}
    	</div>
    </div>
    
    <!-- BatchOperation -->
    </div>
    <script>
        function changeIsShow(userId, status) {
            if (status == 0) {
                var tips = '确定启用?'
                var tip = '启用成功'
            } else {
                var tips = '确定禁用?'
                var tip = '禁用成功'
            }
            layer.confirm(tips, {icon: 3, status: '修改状态'}, function (user) {
                $.ajax({
                    url: "{{url('admin/user/userShowChange')}}",
                    data: {userId: userId, status: status},
                    type: 'get',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 1) {
                            layer.msg(tip, {time: 1000, icon: 6}, function () {
                                window.location.reload();
                            });
                        } else {
                            layer.msg('失败', {icon: 5});
                        }
                    }
                })
            });
        }
    </script>
@endsection