@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">权限管理</a></li>
        <li class="active">角色列表</li>
    </ol>
    <div class="container" style="width:100%">
    <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/permission/roleAdd')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加角色
                        </a>
                    </td>
                    <td class="col-md-6">
                    </td>
                    <td class="col-md-3"></td>
                </tr>
            </table>
        </span>
    </div>
        <table class="table-hover table table-bordered">
            <thead>
            <tr class="active">
                <th>id</th>
                <th>角色名称</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roleList as $k=>$v)
                <tr>
                    <td>{{$v->roleId}}</td>
                    <td>{{$v->roleName}}</td>
                    <td>
                        @if($v->status)
                            <font color="green">启用</font>
                        @else
                            <font color="red">不启用</font>
                        @endif
                    </td>
                    <td class="col-md-3">
                        <a href="{{url('admin/permission/roleEdit')}}?roleId={{$v->roleId}}" title="编辑"
                           class="btn btn-primary btn-xs">编辑</a>
                        <a href="javascript:;" onclick="delRole({{$v->roleId}})" title="删除"
                           class="btn btn-danger btn-xs">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        function delRole(roleId) {
            layer.msg('您确定要删除吗？', {
                icon: 3
                , btn: ['是', '否']
                , btn1: function () {
                    $.ajax({
                        url: "{{url('admin/permission/roleDel')}}",
                        data: {roleId: roleId},
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