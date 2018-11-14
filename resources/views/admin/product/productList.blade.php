@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active">商品列表</li>
    </ol>
    <div class="container" style="width:100%">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/product/add_product')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加商品
                        </a>
                    </td>
                    <td class="col-md-9">
                <form action="{{URL::asset('admin/product/productList')}}" method="get" style="width: 100%"
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
                <th>基本属性</th>
                <th>总库存</th>
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
                    <td>{{mb_substr($v->goodsName,0,10)}}</td>
                    <td><img src="{{URL::asset('/')}}{{$v->goodsImg}}" alt="" style="width:30px;"></td>
                    <td>{{$v->marketPrice}}</td>
                    <td>{{$v->shopPrice}}</td>
                    <td>
                        @foreach($v->goodsSpec as $key=>$val)
                        {{$val['attrName']}}:{{$val['avName']}},
                        @endforeach
                    </td>
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
                        @endif</td>
                    <td>
                        <a title="查看" target="_blank" href="{{url('goods/detail')}}?goodsId={{$v->goodsId}}" class="btn btn-primary btn-xs
                                            ">查看</a>
                        <a title="编辑" href="product_update?id={{$v->goodsId}}" class="btn btn-primary btn-xs">编辑</a>
                        <a title="删除" href="product_del?id={{$v->goodsId}}" class="btn btn-danger btn-xs" id="btn"
                           name="{{$v->goodsId}}">删除</a>
<!--                       <a title="SKU" href="goodsSku?id={{$v->goodsId}}" class="btn btn-danger btn-xs" 
                           name="{{$v->goodsId}}">SKU</a> -->
                        
                       <a title="SKU" href="skuOne?goodsId={{$v->goodsId}}" class="btn btn-danger btn-xs" 
                           name="{{$v->goodsId}}">查看SKU</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <label id="quan" class="btn btn-primary btn-xs" isChecked='1'>全选</label>
        <input type="button" value="批量删除" id="pi" class="btn btn-danger btn-xs">
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

        $(document).on('click', '#pi', function () {
            var ids = []
            var suo = $("input:checked")
            $.each(suo, function (k, v) {
                ids.push(v.value)
            })
            $.ajax({
                url: "{{URL::asset('admin/product/product_pi')}}",
                data: {ids: ids},
                success: function (res) {
                    if (res == 1) {
                        alert('删除成功')
                        location.href = "{{URL::asset('admin/product/productList')}}";
                    }
                }
            })
        })

        $(document).on('click', '#btn', function (e) {
            e.preventDefault()
            var id = $(this).attr('name')
            if (confirm('确实要删除数据吗？')) {
                $.ajax({
                    url: "{{url('admin/product/product_del')}}",
                    headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    type: 'get',
                    data: {id: id},
                    success: function (res) {
                        if (res) {
                            location.href = "{{url('admin/product/productList')}}"
                        }
                    }
                })
            } else {
                return false;
            }

        })


        $(document).on('change', "#catId", function () {
            $("#form").submit();
        })

    </script>
@endsection