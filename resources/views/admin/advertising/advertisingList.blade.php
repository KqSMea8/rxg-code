@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">广告管理</a></li>
        <li class="active">广告列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/advertising/advertisingShow')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加广告
                        </a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('admin/advertising/advertisingList')}}" method="get" style="width: 100%" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="username" placeholder="请输入广告名称···" class="form-control" value="{{$name}}" style="width: 300px">
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
            <thead style="margin-top: 10px;">
            <tr class="active">
                <th>广告编号</th>
                <th>广告名称</th>
                <th>广告位置</th>
                <th>省份</th>
                <th>媒介类型</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $v)
                <tr>
                    <td>{{$v->aid}}</td>
                    <td>{{$v->uname}}</td>
                    <td>
                        @if($v->place==1)
                            <p>首页导航下方通栏</p>
                        @elseif($v->place==2)
                            <p>文章详情侧边栏</p>
                        @elseif($v->place==3)
                            <p>具体根据客户需求吧</p>
                        @endif
                    </td>
                    <td>{{$v->province}}</td>
                    <td>
                        @if($v->type==1)
                            <p>图片</p>
                                <img src="{{URL::asset('')}}{{$v->img}}" width="60" height="60">
                            
                        @elseif($v->type==2)
                            <p>文字</p>
                            {{$v->details}}
                        @endif
                    </td>
                    <td>{{$v->stime}}</td>
                    <td>{{$v->otime}}</td>
                    <td class="center">
                        <a href="up?id={{$v->aid}}" title="编辑" class="btn btn-primary btn-xs">编辑</a>
                        <a href="javascript:void(0)" id="dele" d-id="{{$v->aid}}" class="btn btn-danger btn-xs">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right">
            {{$data->links()}}
        </div>
    </div>
<script>
        $("a[id='dele']").on('click',function(){
            // alert(1);return
            var this0 = $(this);
            var aid = this0.attr('d-id');
            layer.msg('您确定要删除吗？',{
                icon:3,
                btn:['是','否'],
                btn1:function(){
                    
            $.ajax({
                url:"{{url('admin/advertising/del')}}",
                type:'GET',
                data:{id:aid},
                dataType:'json',
                success:function(res){
                        // alert(res.message);return
                    if (res.code === 1) {
                    layer.msg('删除成功',{
                        time:1000,
                        icon:1
                       })
                    }else{
                        layer.msg('删除失败',{
                            time:1000,
                            icon:2
                        });
                    }
                    history.go(0)
                }
            })
        }
    })
})
</script>
@endsection