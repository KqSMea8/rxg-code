@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <div class="container" style="margin-top: 2%;">
        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><em>店铺修改</em></span>
        </div>
        <form action="{{url('admin/store/storeEdit')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
                <input type="hidden" name="shopId" value="{{$shopInfo->shopId}}">
                <tr>
                    <td class="col-lg-2 text-right">店铺编号：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" name="shopSn" value="{{$shopInfo->shopSn}}" disabled/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">店铺图标：</td>
                    <td class="col-lg-6 input-group-sm">
                        <img src="{{URL::asset($shopInfo->shopImg)}}" height="50px">
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">店铺名称：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" name="shopName" value="{{$shopInfo->shopName}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">店主：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" value="{{$shopInfo->userName}}" disabled/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否自营：</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($isSelf as $k=>$v)
                            <input type="radio" name="isSelf" value="{{$k}}" class="textBox" {{($k==$shopInfo->isSelf)?'checked':''}}>{{$v}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">店铺状态：</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($shopStatus as $k=>$v)
                            <input type="radio" name="shopStatus" value="{{$k}}" class="textBox" {{($k==$shopInfo->shopStatus)?'checked':''}}>{{$v}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">
                    </td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/store/storeList')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回店铺列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 确认修改店铺
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $('button[id="submit"]').on('click',function (e) {
            e.preventDefault();
            var data = new FormData($("#form")[0]);
            $.ajax({
                url:"{{url('admin/store/storeEdit')}}",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                dataType:'json',
                type:'post',
                data:data,
                cache: false,
                processData: false,
                contentType: false,
                success:function (res) {
                    if(res.code === 1){
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        },function () {
                            window.location.href="{{url('admin/store/storeList')}}";
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