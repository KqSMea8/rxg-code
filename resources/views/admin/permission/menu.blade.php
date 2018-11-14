@extends('admin.layout.default')
@section('content')
<ol class="breadcrumb" style="margin-top: 10px;">
    <li><a href="#">权限管理</a></li>
    <li class="active">权限列表</li>
</ol>
<div class="container" style="width:100%">
    <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/permission/powerAdd')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加权限
                        </a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('admin/permission/menu')}}" method="get" style="width: 100%" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="请输入权限名称···" class="form-control" value="{{$keyword}}" style="width: 300px">
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
            <th>权限名称</th>
            <th>权限url</th>
            <th>状态</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($powerList as $k=>$v)
            <tr>
                <td>
                    <input type="checkbox" name="powerId[]" value="{{$v->powerId}}">
                    {{$v->powerId}}
                </td>
                <td>{{($v->parentId==0)?'':'|---'}}<?=$v->powerName?></td>
                <td>{{$v->powerUrl}}</td>
                <td>
                    @if($v->status)
                        <font color="green">已启用</font>
                    @else
                        <font color="red">未启用</font>
                    @endif
                </td>
                <td>
                    @if($v->isShow)
                        展示
                    @else
                        不展示
                    @endif
                </td>
                <td>
                    <a href="{{url('admin/permission/powerEdit')}}?powerId={{$v->powerId}}" title="编辑"
                       class="btn btn-primary btn-xs">编辑</a>
                    <a href="javascript:;" onclick="delPower({{$v->powerId}})" title="删除"
                       class="btn btn-danger btn-xs">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="float:right">
        {{$powerList->links()}}
    </div>
</div>
<script>
    function delPower(powerId) {
        layer.msg('您确定要删除吗？', {
            icon: 3
            , btn: ['是', '否']
            , btn1: function () {
                $.ajax({
                    url: "{{url('admin/permission/powerDel')}}",
                    data: {powerId: powerId},
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code === 1) {
                            layer.msg('删除成功', {
                                time: 1000,
                                icon: 1
                            }, function () {
                                history.go(0)
                            })
                        } else {
                            layer.msg(res.message, {
                                time: 2000,
                                icon: 2
                            })
                        }
                    }
                })
            }
        })
    }
</script>
@endsection