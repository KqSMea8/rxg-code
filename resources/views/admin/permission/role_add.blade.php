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
        <li><a href="{{url('admin/permission/roleList')}}">角色列表</a></li>
        <li class="active">角色添加</li>
    </ol>
    <div class="container" style="margin-top: 2%;width:100%">
        <form id="form" action="{{url('admin/permission/roleAdd')}}" method="post">
            {{csrf_field()}}
            <table class="list-style">
                <tr>
                    <td class="col-md-2 text-right">角色名称：</td>
                    <td class="col-md-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写角色名称" name="roleName"/>
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
                        <a href="{{url('admin/permission/roleList')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回角色列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 添加新角色
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
                url: "{{url('admin/permission/roleAdd')}}",//url
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
                            location.href = "{{url('admin/permission/roleList')}}";
                        });
                    }
                }
            })
        })
    </script>
@endsection