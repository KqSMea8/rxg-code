@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">权限管理</a></li>
        <li><a href="{{url('admin/permission/menu')}}">权限列表</a></li>
        <li class="active">编辑</li>
    </ol>
    <div class="container" style="margin-top: 2%;width:100%">
        <form action="{{url('admin/permission/powerAdd')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
                <input type="hidden" name="powerId" value="{{$powerInfo->powerId}}">
                <tr>
                    <td class="col-lg-2 text-right">权限名称：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写权限名称" name="powerName"
                               value="{{$powerInfo->powerName}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择上级权限：</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="parentId" class="form-control">
                            <option value="">--请选择--</option>
                            <option value="0" {{(0==$powerInfo->parentId)?'selected':''}}>顶级权限</option>
                            @foreach($powerList as $k=>$v)
                                <option value="{{$v->powerId}}" {{($v->powerId==$powerInfo->parentId)?'selected':''}}>
                                    |--<?=$v->powerName?>
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">权限URL：</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" class="form-control"
                                                               placeholder="例如:admin/index/index 或 #" name="powerUrl"
                                                               value="{{$powerInfo->powerUrl}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否展示：</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($isShow as $k=>$v)
                            <input type="radio" name="isShow" value="{{$k}}"
                                   class="textBox" {{($k==$powerInfo->isShow)?'checked':''}}>{{$v}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否启用：</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($status as $k=>$v)
                            <input type="radio" name="status" value="{{$k}}"
                                   class="textBox" {{($k==$powerInfo->status)?'checked':''}}>{{$v}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">
                    </td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/permission/menu')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回权限列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 确认修改权限
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $('button[id="submit"]').on('click', function (e) {
            e.preventDefault();
            var formData = $("#form").serialize();
            $.ajax({
                type: "post",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "{{url('admin/permission/powerEdit')}}",//url
                data: formData,
                success: function (res) {
                    if (parseInt(res.code) === 2) {
                        layer.msg(res.message, {
                            time: 1000,
                            icon: res.code
                        });
                    } else {
                        layer.msg(res.message, {
                            time: 1000,
                            icon: res.code
                        }, function () {
                            location.href = "{{url('admin/permission/menu')}}";
                        });
                    }
                }
            })
        })
    </script>
@endsection