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
            <span style="font-size: 16px;"><em>角色修改</em></span>
        </div>
        <form action="{{url('admin/permission/roleEdit')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
                <input type="hidden" name="roleId" value="{{$roleInfo->roleId}}">
                <tr>
                    <td class="col-lg-2 text-right">角色名称：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写角色名称" name="roleName"
                               value="{{$roleInfo->roleName}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否启用：</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($status as $k=>$v)
                            <input type="radio" name="status" value="{{$k}}"
                                   class="textBox" {{($k==$roleInfo->status)?'checked':''}}>{{$v}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">
                    </td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/permission/roleList')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回角色列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 确认修改角色
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
                url: "{{url('admin/permission/roleEdit')}}",//url
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
                            location.href = "{{url('admin/permission/roleList ')}}";
                        });
                    }
                }
            })
        })
    </script>
@endsection