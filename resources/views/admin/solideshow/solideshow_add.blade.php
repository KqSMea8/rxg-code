@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">轮播图管理</a></li>
        <li><a href="{{url('admin/solideshow/solideshowList')}}">轮播图列表</a></li>
        <li class="active">轮播图添加</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form  id="form" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <table>
                <tr>
                    <td class="col-md-2 text-right">轮播图名称：</td>
                    <td class="col-md-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写轮播图名称" name="img_name"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">轮播图URL：</td>
                    <td class="col-md-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写轮播图URL" name="img_url"/>
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否启用：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="is_show" value="1">启用
                        <input type="radio" name="is_show" value="0">禁用
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择轮播图：</td>
                    <td class="col-lg-6 input-group-sm">
                        {{--<img src="{{URL::asset('img/up.png')}}" id="add-img" title="添加图片" style="border:1px solid #d2d6de; max-width: 120px;"/>--}}
                        <input type="file" id="file_put" name="img_path" accept="image/*" style="display: block">
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-2 text-left">
                        <a href="{{url('admin/solideshow/solideshowList')}}"class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回轮播图列表</a>
                        <input type="submit" class="btn" style="background-color: #4fd98b;width: 150px" value="确定"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $("input[type='submit']").on('click',function (e){
            e.preventDefault();

            var data = new FormData($("#form")[0]);
            $.ajax({
                url:"{{url('admin/solideshow/solideShowAddDo')}}",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                dataType:'json',
                type:'post',
                data:data,
                cache: false,
                processData: false,
                contentType: false,
                success:function (res) {
                    if(res.code == 1){
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        },function () {
                            window.location.href="{{url('admin/solideshow/solideshowList')}}";
                        });
                    }else{
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        });
                    }

                }
            })
        })
    </script>
@endsection