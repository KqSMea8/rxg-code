@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">权限管理</a></li>
        <li class="active">管理员列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/permission/personAdd')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加管理员
                        </a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('admin/permission/person')}}" method="get" style="width: 100%;" class="form-inline" id="form">
                    <select name="status" class="form-control" onchange="statusSearch()">
                                @foreach($statusArr as $k=>$v)
                            <option value="{{$k}}" {{($k==$status)?'selected':''}}>{{$v}}</option>
                        @endforeach
                    </select>
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="请输入管理员名称···" class="form-control" value="{{$keyword}}" style="width: 300px;">
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
                <th>id</th>
                <th>管理员用户名</th>
                <th>所属角色</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($adminList as $k=>$v)
                <tr>
                    <td>{{$v->adminId}}</td>
                    <td>{{$v->adminName}}</td>
                    <td>{{$v->roleName}}</td>
                    <td>
                        @if($v->status)
                            <font color="green">已启用</font>
                        @else
                            <font color="red">未启用</font>
                        @endif
                    </td>
                    <td>
                        <a href="{{url('admin/permission/personEdit')}}?adminId={{$v->adminId}}" title="编辑"
                           class="btn btn-primary btn-xs" {{(intval($v->roleId)===3)?'disabled':''}}>编辑</a>
                        <a href="javascript:;" onclick="delPerson({{$v->adminId}})" title="删除"
                           class="btn btn-danger btn-xs" {{(intval($v->roleId)===3)?'disabled':''}}>删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float:right">
            {{$adminList->links()}}
        </div>
    </div>
    <script>
        function statusSearch() {
            $("#form").submit();
        }

        function delPerson(adminId) {
            layer.msg('您确定要删除吗？', {
                icon: 3
                , btn: ['是', '否']
                , btn1: function () {
                    $.ajax({
                        url: "{{url('admin/permission/personDel')}}",
                        data: {adminId: adminId},
                        type: 'GET',
                        dataType: 'json',
                        success: function (res) {
                            if (res.code === 1) {
                                layer.msg('删除成功', {
                                    time: 1000,
                                    icon: 1
                                })
                            } else {
                                layer.msg('删除失败', {
                                    time: 1000,
                                    icon: 2
                                })
                            }
                            history.go(0)
                        }
                    })
                }
            })
        }
    </script>
@endsection