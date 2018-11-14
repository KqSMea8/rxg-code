@extends('admin.layout.default')
@section('content')
<style>
    #tds{
        position:relative;
    }
    #divs{
        position:absolute; top:100px; left:500px;
        z-index: 999;
        width:200px;
        height:200px;
        background-color: #FFFFFF;
        border: 1px solid #ddd;
        font-size: 16px;
        line-height: 30px;
    }
</style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">活动管理</a></li>
        <li class="active">活动列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/activity/activityAdd')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加活动
                        </a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('admin/activity/activityList')}}" method="get" style="width: 100%" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="请输入活动名称···" class="form-control" value="{{$keyword}}" style="width: 300px">
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
        <table class="table-hover table table-bordered" id='tds'>
            <thead>
            <tr class="active">
                <th>ID</th>
                <th>活动名称</th>
                <th>商品分类</th>
                <th>活动商品</th>
                <th>商品图片</th>
                <th>活动时间</th>
                <th>活动描述</th>
                <th>活动类型</th>
                <th>优惠(元)</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
             @foreach ($data as $k =>$v)
             <tr align='center'>
                <td>{{$v->id}}</td>
                <td>{{$v->activityName}}</td>
                <td>{{$v->catName}}</td>
                <td>{{$v->goodsName}}</td>
                <td><img src="{{URL::asset('/')}}{{$v->goodsImg}}" alt="" style="width:30px;"></td>
                <td>{{$v->sTime}}--{{$v->oTime}}</td>
                <td>
                    <span onclick="spans(this)">查看详情</span>
                    <div style='display:none' id='divs' onmouseout='fun(this)'>{{$v->activityDesc}}</div>
                </td>
                <td>@if($v->activityClass == 1)
                  <font>分享优惠</font>
                  @else
                  <font>分享返利</font>
                  @endif</td>
                <td>{{$v->favourable}}</td>
                <td class="center"> 
                    <a href="up?id={{$v->id}}" title="编辑" class="btn btn-primary btn-xs">编辑</a>
                    <a title="删除" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="activityDel({{$v->id}})">删除</a>
                </td>
            </tr>
           @endforeach
            </tbody>
        </table>
        <div style="float: right">
            {{$data->links()}}
        </div>
    </div>
    {{--<input type="checkbox" value="{{$v->id}}" name="item[]" class='ck'>--}}
    {{--<input type="checkbox" name="dx" value="''" onclick="checkall(tdis)">--}}
    <script type="text/javascript">
        function activityDel(id){
            layer.msg('您确定要删除吗？',{
                icon: 3
                ,btn:['是','否']
                ,btn1:function(){
                    $.ajax({
                        url:"{{url('admin/activity/activityDel')}}",
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
        //详情
        function spans(own){
            // var id = $(this).val();
            $(own).next().show();
        }
        function fun(own){
            $(own).hide();
        }
    </script>
@endsection