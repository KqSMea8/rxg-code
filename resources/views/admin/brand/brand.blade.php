@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">品牌管理</a></li>
        <li class="active">品牌列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/brand/brandAdd')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加品牌
                        </a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('admin/brand/brandList')}}" method="get" style="width: 100%"
                      class="form-inline" id="form">
                    <div class="input-group">
                        <input type="text" name="username" placeholder="请输入品牌名称···" class="form-control"
                               value="{{$uname}}" style="width: 300px">
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
                <th>品牌编号</th>
                <th>品牌名称</th>
                <th>品牌图片</th>
                <th>品牌描述</th>
                <th>品牌状态</th>
                <th>添加时间</th>
                <th>品牌分类</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $v)
                <tr>
                    <td>{{$v->brandId}}</td>
                    <td>{{$v->brandName}}</td>
                    <td>
                    	<img src="{{URL::asset('')}}{{$v->brandImg}}" width="60" height="60">
                    </td>
                    <td>{{$v->brandDesc}}</td>
                    <td>
                        @if($v->status==1)
                        	可用
                        @elseif($v->status==0)
                        	不可用
                        @endif
                    </td>
                    <td>{{$v->addTime}}</td>
                    <td>{{$v->catName}}</td>
                    <td class="center">
                        <a href="up?id={{$v->brandId}}" title="编辑" class="btn btn-primary btn-xs">编辑</a>
                        <a title="删除" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="brandDel({{$v->brandId}})">删除</a>
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
<script type="text/javascript">
    function brandDel(id){
            layer.msg('您确定要删除吗？',{
                icon: 3
                ,btn:['是','否']
                ,btn1:function(){
                    $.ajax({
                        url:"{{url('admin/brand/brandDel')}}",
                        data:{id:id},
                        type:'GET',
                        dataType:"json",
                        success:function(res){
                            if (res.code===1) {
                                layer.msg('删除成功',{
                                    time:1000,
                                    icon:1
                                })
                            }else{
                                layer.msg('删除失败',{
                                    time:1000,
                                    icon:2
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