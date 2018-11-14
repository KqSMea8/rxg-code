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
            <span style="font-size: 16px;"><em>登录密码修改</em></span>
            <span class="pull-right">
                <a href="{{url('merchant/merchant/index')}}"
                   class="btn btn-primary btn-xs"><-返回</a>
            </span>
        </div>
        <form id="form" method="post" enctype="multipart/form-data">
            <table>
                {{csrf_field()}}
                <tr>
                    <td class="col-lg-2 text-right">输入密码</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="pwd" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">确认密码</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="repwd" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-4 input-group-sm text-center">
                        <input type="submit" value="确认" class="btn" style="background-color: #4fd98b;width: 50%"/></td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        {{--action="{{url('merchant/goods/goodsAddDo')}}"--}}
        $("input[type='submit']").on('click',function (e){
            e.preventDefault();

            var data = new FormData($("#form")[0]);
            $.ajax({
                url:"{{url('merchant/merchant/updateDo')}}",
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
                            window.location.href="{{url('merchant/goods/goodsList')}}";
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
