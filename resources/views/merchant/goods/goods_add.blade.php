@extends('merchant.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active">添加商品</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('merchant/goods/goodsList')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-hand-left"></i> 返回
                        </a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('merchant/goods/goodsAdd')}}" method="get" style="width: 100%"
                      class="form-inline" id="form">
                    <select name="catId" class="form-control" id="catId">
                               <option value="">--按分类筛选--</option>
                        @foreach($goodscats as $k=>$v)
                            <option value="{{$v['catId']}}" {{($v['catId']==$catId)?"selected":''}}>{{$v['catName']}}</option>
                        @endforeach
                            </select>
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="请输入商品名称···" class="form-control"
                               value="{{$keyword}}" style="width: 300px">
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
                <th>选择</th>
                <th>ID编号</th>
                <th>名称</th>
                <th>商品图片</th>
                <th>市场价(元)</th>
                <th>会员价(元)</th>
                <th>库存</th>
                <th>精品</th>
                <th>上架</th>
                <th>热销</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$v)
                <tr>
                    <td style="text-align:center"><input type="checkbox" value="{{$v->goodsId}}"/></td>
                    <td style="text-align:center">{{$v->goodsId}}</td>
                    <td>{{$v->goodsName}}</td>
                    <td><img src="{{URL::asset('/')}}{{$v->goodsImg}}" alt="" style="width:30px;"></td>
                    <td>{{$v->marketPrice}}</td>
                    <td>{{$v->shopPrice}}</td>
                    <td>{{$v->goodsStock}}</td>
                    <td style="text-align:center">
                        @if($v->isBest==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif
                    </td>
                    <td style="text-align:center">@if($v->isSale==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif</td>
                    <td style="text-align:center">@if($v->isHot==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif
                    </td>
                    <td>
                        <input type="button" value="上架到店铺" onclick="addToShop({{$v->goodsId}})"
                               class="btn btn-primary btn-xs">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <label id="quan" class="btn btn-primary btn-xs" isChecked='1'>全选</label>
        <input type="button" value="批量上架到店铺" id="pi" class="btn btn-primary btn-xs">
        <div style="float:right">
            {{$data->links()}}
        </div>
    </div>
    <script>
        $(document).on("click", "#quan", function () {
            var xuan = $(this).attr('isChecked')
            var BoxLength = $("input:checkbox").length;
            var status = '';
            if (xuan == 1) {
                status = true;
                $(this).attr('isChecked', 2);
                $('#quan').text('全不选')
            } else {
                status = false;
                $(this).attr('isChecked', 1);
                $('#quan').text('全选')
            }

            for (var i = 0; i < BoxLength; i++) {
                $("input:checkbox")[i].checked = status;
            }
        })

        function addToShop(id) {
            $.ajax({
                url: "{{url('merchant/goods/goodsAddDo')}}",
                data: {id: id},
                type: 'get',
                success:function (res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, {time: 1000, icon: 6}, function () {
                            window.location.reload();
                        });
                    } else {
                        layer.msg(res.msg, {icon: 5});
                    }
                }
            })
        }

        $("#pi").on('click',function () {
            var id = [];
            var all = $("input:checked");
            $.each(all, function (k, v) {
                id.push(v.value);
            })
            $.ajax({
                url:"{{url('merchant/goods/goodsAddDo')}}",
                data:{id:id},
                type:'get',
                success:function (res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, {time: 1000, icon: 6}, function () {
                            window.location.reload();
                        });
                    } else {
                        layer.msg(res.msg, {icon: 5});
                    }
                }
            })
        })

        $(document).on('change', "#catId", function () {
            $("#form").submit();
        })

    </script>
@endsection