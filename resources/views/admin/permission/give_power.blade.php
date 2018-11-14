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
        <li class="active">权限分配</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form action="{{url('admin/permission/givePower')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
                <tr>
                    <td class="col-md-1 text-right">选择角色：</td>
                    <td class="col-md-10 input-group-sm">
                        <select name="roleId" class="form-control" style="width: 300px" onchange="isCheck(this.value)">
                            <option value="">--请选择角色--</option>
                            @foreach($roleList as $k=>$v)
                                <option value="{{$v->roleId}}">{{$v->roleName}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="col-md-1"></td>
                </tr>
                <tr>
                    <td class="col-md-1 text-right">选择权限：</td>
                    <td class="col-md-10 input-group-sm">
                        @foreach($powerList as $k=>$v)
                            <dl class="dl-horizontal dl_box" style="margin-left: -80px">
                                <dt>
                                    <input type="checkbox" name="powerId" value="{{$v->powerId}}"/><?=$v->powerName?>
                                </dt>
                                <dd>
                                    |---
                                    @foreach($v->child as $key=>$val)
                                        <input type="checkbox" name="powerId"
                                               value="{{$val->powerId}}"/>{{$val->powerName}}
                                    @endforeach
                                </dd>
                            </dl>
                        @endforeach
                    </td>
                    <td class="col-md-1"></td>
                </tr>
                <tr>
                    <td class="col-lg-6 input-group-sm text-center" colspan="2">
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 分配权限
                        </button>
                    </td>
                    <td class="col-md-3"></td>
                </tr>
            </table>
        </form>
        <!-- BatchOperation -->
    </div>
    <script>
        $(document).on('click', '.dl_box dt input', function () {
            var obj = $(this);
            if (obj.prop('checked') === true) {
                obj.parent().next().children().prop('checked', true);
            } else {
                obj.parent().next().children().prop('checked', false);
            }
        });
        $(document).on('click', '.dl_box dd input', function () {
            var obj = $(this);
            obj.parent().prev().children().prop('checked', true);
        });

        function isCheck(roleId) {
            var checkbox = $("input[name='powerId']");
            checkbox.each(function (k, v) {
                $(v).prop('checked', false)
            });
            if (roleId === '') {
                checkbox.each(function (k, v) {
                    $(v).prop('checked', false)
                });
            } else {
                var rolePower = @json($rolePower)[roleId];
                $(rolePower).each(function (k, v) {
                    $("input:checkbox[value='" + v + "']").prop('checked', true);
                })
            }
        }

        $('button[id="submit"]').on('click', function (e) {
            e.preventDefault();
            var loadO = layer.load(1);
            var addPowerId = [];
            var delPowerId = [];
            var checkbox = $("input[name='powerId']");
            checkbox.each(function (k, v) {
                if ($(v).prop('checked') === true) {
                    addPowerId.push($(v).val());
                } else {
                    delPowerId.push($(v).val());
                }
            });
            var roleId = $("select[name='roleId']").val();
            $.ajax({
                type: "post",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "{{url('admin/permission/givePower')}}",//url
                data: {roleId: roleId, addPowerId: addPowerId, delPowerId: delPowerId},
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                success: function (res) {
                    layer.close(loadO);
                    layer.msg(res.message, {
                        time: 1000,
                        icon: 1
                    });
                }
            })
        })
    </script>
@endsection