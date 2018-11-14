@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active">属性列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/attribute/attrAdd')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加属性
                        </a>
                    </td>
                    <td class="col-md-9">
                    <form action="{{URL::asset('admin/attribute/attrList')}}" method="get" style="width: 100%" class="form-inline" id="form">
                        <div class="input-group">
                            <input type="text" name="attrName" placeholder="请输入属性名称···" class="form-control" value="{{$attrName}}" style="width: 300px">
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
                <th>属性id</th>
                <th>属性名称</th>
                <th>属性类型</th>
                <th>属性分类</th>
                <th>属性值</th>
                <th>是否展示</th>
                <th>属性状态</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($attrList as $k=>$v)
                <tr>
                    <td>{{$v->attrId}}</td>
                    <td>{{$v->attrName}}</td>
                    <td>
                        @if($v->attrType==1)
                            销售属性
                        @else
                            基本属性（规格）
                        @endif
                    </td>
                    <td>{{$v->catName}}</td>
                    <td>
                        @foreach($v->attrValue as $key=>$val)
                            {{$val->avName}}，
                        @endforeach
                    </td>
                    <td>
                        @if($v->isShow==1)
                            展示
                        @else
                            不展示
                        @endif
                    </td>
                    <td>
                        @if($v->status==1)
                        	可用
                        @elseif($v->status==0)
                        	不可用
                        @endif
                    </td>
                    <td>{{$v->addTime}}</td>
                    <td>
                        <a href="{{url('admin/attribute/attrEdit')}}?attrId={{$v->attrId}}" title="编辑" class="btn btn-primary btn-xs">编辑</a>
                        <a title="删除" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="attrDel({{$v->attrId}})">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right">
            {{$attrList->links()}}
        </div>
    </div>
    </div>
<script type="text/javascript">
    function attrDel(attrId){
            layer.msg('您确定要删除吗？',{
                time:0,
                icon: 3
                ,btn:['是','否']
                ,btn1:function(){
                    $.ajax({
                        url:"{{url('admin/attribute/attrDel')}}",
                        data:{attrId:attrId},
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