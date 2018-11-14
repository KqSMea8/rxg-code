@extends('merchant.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">物流管理</a></li>
        <li class="active">物流列表</li>
    </ol>
    <div class="container" style="width: 100%;">
        <div style="margin-bottom: 1%">
            <span>
                <table width="100%;">
                    <tr class="row">
                        <td class="col-md-3">
                            <a href="{{url('merchant/logistics/logisticsadd')}}" class="btn btn-warning">
                                <i class="glyphicon glyphicon-plus"></i> 添加物流
                            </a>
                        </td>
                        <td class="col-md-9">
                            <form action="{{URL::asset('merchant/logistics/logisticslist')}}" method="get"
                                  style="width: 100%;" class="form-inline">
                                <div class="input-group">
                                 <input type="text" name="keyword" placeholder="请输入物流名称···" class="form-control">
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
                <th>编号</th>
                <th>物流名称</th>
                <th>联系电话</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->tel}}</td>
                    <td>
                        <a href="{{url('merchant/logistics/logisticsEdit')}}?id={{$v->id}}" title="编辑" class="btn btn-primary btn-xs">编辑</a>
                        <a href="javascript:;" onclick="delPower({{$v->powerId}})" title="删除" class="btn btn-danger btn-xs">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float:right">
			{{$data->links()}}
        </div>
    </div>
    <!--<script>
        function delPower(powerId) {
            layer.msg('您确定要删除吗？', {
                icon: 3
                ,btn: ['是','否']
                ,btn1:function () {
                    $.ajax({
                        url:"{{url('admin/permission/powerDel')}}",
                        data:{powerId:powerId},
                        type:'GET',
                        dataType:'json',
                        success:function (res) {
                            if(res.code===1){
                                layer.msg('删除成功',{
                                    time:1000,
                                    icon:1
                                },function () {
                                    history.go(0)
                                })
                            }else{
                                layer.msg(res.message,{
                                    time:2000,
                                    icon:2
                                })
                            }
                        }
                    })
                }
            })
        }
    </script>-->
@endsection