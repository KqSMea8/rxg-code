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
        <li><a href="{{url('admin/permission/person')}}">管理员列表</a></li>
        <li class="active">管理员添加</li>
    </ol>

    <div class="container" style="margin-top: 2%;width:100%">
        <form action="{{url('admin/permission/personAdd')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
                <tr>
                    <td class="col-md-2 text-right">管理员用户名：</td>
                    <td class="col-md-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写管理员用户名" name="adminName"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">所属角色：</td>
                    <td class="col-md-6 input-group-sm">
                        <select name="roleId" class="form-control">
                            <option value="">--请选择角色--</option>
                            @foreach($roleList as $k=>$v)
                                <option value="{{$v->roleId}}">{{$v->roleName}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">管理员登录密码：</td>
                    <td class="col-md-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写管理员登录密码" name="password"/>
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否启用：</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($status as $k=>$v)
                            <input type="radio" name="status" value="{{$k}}" class="textBox"
                                   @if($k)checked @endif>{{$v}}
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
                            <i class="glyphicon glyphicon-plus"></i> 添加新管理员
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
                url: "{{url('admin/permission/personAdd')}}",//url
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