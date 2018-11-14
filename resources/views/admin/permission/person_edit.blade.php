@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <div class="container" style="margin-top: 2%;width:100%">
        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><em>管理员信息修改</em></span>
        </div>
        <form action="" method="post" id="form">
            {{csrf_field()}}
            <table>
                <input type="hidden" name="adminId" value="{{$adminInfo->adminId}}">
                <tr>
                    <td class="col-lg-2 text-right">管理员用户名：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写管理员名称" name="adminName"
                               value="{{$adminInfo->adminName}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">所属角色：</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="roleId" class="form-control">
                            <option value="">--请选择--</option>
                            @foreach($roleList as $k=>$v)
                                <option value="{{$v->roleId}}" {{($v->roleId==$adminInfo->roleId)?'selected':''}}>
                                    {{$v->roleName}}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">管理员登录密码：</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" class="form-control" placeholder="请填写管理员登录密码"
                                                               name="password" value="{{$adminInfo->password}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否启用：</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($status as $k=>$v)
                            <input type="radio" name="status" value="{{$k}}"
                                   class="textBox" {{($k==$adminInfo->status)?'checked':''}}>{{$v}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">
                    </td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/permission/person')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回管理员列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 确认修改管理员
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
                url: "{{url('admin/permission/personEdit')}}",//url
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
                            location.href = "{{url('admin/permission/person')}}";
                        });
                    }
                }
            })
        })
    </script>
@endsection