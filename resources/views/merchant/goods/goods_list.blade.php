@extends('merchant.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active">店铺商品列表</li>
    </ol>
    <div class="container" style="width: 100%;">
        <div style="margin-bottom: 1%">

        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('merchant/goods/goodsAdd')}}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-plus"></i> 添加商品</a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('merchant/goods/goodsList')}}" method="get" style="width: 100%"
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
                <th>市场价</th>
                <th>会员价</th>
                <th>库存</th>
                <th>精品</th>
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
                    <td><img src="{{URL::asset($v->goodsImg)}}" alt="" style="width:30px;"></td>
                    <td>{{$v->marketPrice}}</td>
                    <td>{{$v->shopPrice}}</td>
                    <td>{{$v->goodsStock}}</td>
                    <td>
                        @if($v->isBest==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif
                    </td>
                    <td>
                        @if($v->isHot==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif
                    </td>
                    <td>
                        <a title="下架" href="javascript:;" onclick="del({{$v->goodsId}})" class="btn btn-danger btn-xs">下架</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <label id="quan" class="btn btn-primary btn-xs" isChecked='1'>全选</label>
        <input type="button" value="批量下架" onclick="delall()" class="btn btn-primary btn-xs">
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

        function del(id) {
            layer.confirm('确定要下架？', {icon: 3, title: '修改状态'}, function (index) {
                $.ajax({
                    url: "{{url('merchant/goods/goodsDel')}}",
                    data: {id: id},
                    type: 'get',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 1) {
                            layer.msg(res.msg, {time: 1000, icon: 6}, function () {
                                window.location.reload();
                            });
                        } else {
                            layer.msg(res.msg, {icon: 5});
                        }
                    }
                })
            });
        }

        function delall() {
            var ids = []
            var suo = $("input:checked")
            $.each(suo, function (k, v) {
                ids.push(v.value)
            })
            layer.confirm('确定要下架？', {icon: 3, title: '修改状态'}, function (index) {
                $.ajax({
                    url: "{{url('merchant/goods/goodsDel')}}",
                    data: {id: ids},
                    type: 'get',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 1) {
                            layer.msg(res.msg, {time: 1000, icon: 6}, function () {
                                window.location.reload();
                            });
                        } else {
                            layer.msg(res.msg, {icon: 5});
                        }
                    }
                })
            });
        }
        {{--$(document).on('click', '#pi', function () {--}}
        {{--var ids = []--}}
        {{--var suo = $("input:checked")--}}
        {{--$.each(suo, function (k, v) {--}}
        {{--ids.push(v.value)--}}
        {{--})--}}
        {{--$.ajax({--}}
        {{--url: "{{URL::asset('admin/product/product_pi')}}",--}}
        {{--data: {ids: ids},--}}
        {{--success: function (res) {--}}
        {{--if (res == 1) {--}}
        {{--alert('删除成功')--}}
        {{--location.href = "{{URL::asset('admin/product/productList')}}";--}}
        {{--}--}}
        {{--}--}}
        {{--})--}}
        {{--})--}}
    </script>
@endsection