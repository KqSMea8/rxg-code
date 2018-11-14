@extends('admin.layout.default')
@section('content')
    <style>
        .table tbody tr td {
            vertical-align: middle;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">轮播图管理</a></li>
        <li class="active">轮播图列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/solideshow/solideShowAdd')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加轮播图
                        </a>
                    </td>
                    <td class="col-md-9">
                    </td>
                </tr>
            </table>
        </span>
        </div>
        <table class="table-hover table table-bordered">
            <thead>
            <tr class="active">
                <th>轮播图编号</th>
                <th>轮播图查看</th>
                <th>轮播图名称</th>
                <th>轮播图URL</th>
                <th>是否启用</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>
                        <img src="{{URL::asset($v->img_path)}}" style="height: 40px;">
                    </td>
                    <td>{{$v->img_name}}</td>
                    <td><a href="{{$v->img_url}}" title="点击查看">{{$v->img_url}}</a></td>
                    <td>
                        @if($v->is_show == 1)
                            是
                        @else
                            否
                        @endif
                    </td>
                    <td class="center">
                        @if($v->is_show == 1)
                            <a href="javascript:;" title="禁用" onclick="changeIsShow({{$v->id}},0)"
                               class="btn btn-primary btn-xs">禁用</a>
                        @else
                            <a href="javascript:;" title="启用" onclick="changeIsShow({{$v->id}},1)"
                               class="btn btn-primary btn-xs">启用</a>
                        @endif
                        <a href="{{url('admin/solideshow/update')}}?id={{$v->id}}" title="编辑"
                           class="btn btn-primary btn-xs">编辑</a>
                        <a title="删除" href="javascript:;" onclick="del({{$v->id}})" class="btn btn-danger btn-xs">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right">
        {{$data->links()}}
    </div>
    </div>
    
    </div>
    <script>
        function changeIsShow(id, is_show) {
            if (is_show == 1) {
                var tips = '确定启用?'
                var tip = '启用成功'
            } else {
                var tips = '确定禁用?'
                var tip = '禁用成功'
            }
            layer.confirm(tips, {icon: 3, title: '修改状态'}, function (index) {
                $.ajax({
                    url: "{{url('admin/solideshow/solideShowChange')}}",
                    data: {id: id, is_show: is_show},
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

        function del(id) {
            layer.confirm('确定要删除？', {icon: 3, title: '修改状态'}, function (index) {
                $.ajax({
                    url: "{{url('admin/solideshow/solideShowDel')}}",
                    data: {id: id},
                    type: 'get',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 1) {
                            layer.msg(res.msg, {time: 1000, icon: 6}, function () {
                                window.location.reload();
                            });
                        } else {
                            layer.msg(res.msg, {icon: 5});
                        }
                    }
                })
            });
        }
    </script>
@endsection