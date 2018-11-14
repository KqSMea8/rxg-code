@extends('merchant.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <div class="container" style="margin-top: 2%;">
        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><em>物流添加</em></span>
        </div>
        <form action="{{url('merchant/logistics/logisticsAdddo')}}" method="post" id="form">
            {{csrf_field()}}
            <table>
            	<input type="hidden" name="id" value="{{$logisticsInfo->id}}">
                <tr>
                    <td class="col-lg-2 text-right">物流公司名称：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="物流仓库公司名称" name="name" value="{{$logisticsInfo->name}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">联系方式：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="联系方式以座机号为主" name="tel" value="{{$logisticsInfo->tel}}"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">
                    </td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('merchant/logistics/logisticslist')}}"
                           class="btn btn-warning" style="width: 150px">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回物流列表
                        </a>
                        <button id="submit" type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i> 修改物流信息
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $('button[id="submit"]').on('click',function (e) {
            e.preventDefault();
            var formData = $("#form").serialize();
            $.ajax({
                type: "post",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "{{url('merchant/logistics/logisticsEdit')}}" ,//url
                data: formData,
                success: function (res) {
                    if(parseInt(res.code)===2){
                        layer.msg(res.message, {
                            time: 1000,
                            icon: res.code
                        })
                    }else {
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        },function () {
                            location.href="{{url('merchant/logistics/logisticsList')}}";
                        });
                    }
                }
            })
        })
    </script>
@endsection