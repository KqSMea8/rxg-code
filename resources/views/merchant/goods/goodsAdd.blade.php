@extends('merchant.layout.default')
@section('content')
<ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active"><a href="{{url('merchant/goods/goodsList')}}">店铺商品列表</a></li>
        <li class="activ">商城商品列表</li>
    </ol>
    <div class="container" style="width: 100%;">
        <div style="margin-bottom: 1%">

        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-9">
                <form action="{{URL::asset('merchant/goods/show')}}" method="get" style="width: 100%"
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
                <th>ID编号</th>
                <th>名称</th>
                <th>商品图片</th>
                <th>市场价</th>
                <th>会员价</th>
                <th>库存</th>
                <th>精品</th>
                <!-- <th>上架</th> -->
                <th>热销</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <form action=""></form>
            @foreach($data as $k=>$v)
                <tr>
                    <td>{{$v->goodsId}}</td>
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
                    <!-- <td>@if($v->isSale==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif</td> -->
                    <td>@if($v->isHot==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif</td>
                    <td>
                        <a href="{{url('merchant/goods/goodsShow')}}?id={{$shopId}}&&goodsId={{$v->goodsId}}" class="btn btn-danger btn-xs">上架</a>
                        <!-- <a title="编辑" href="{{url('merchant/goods/goodsUp')}}?id={{$v->goodsId}}" class="btn btn-primary btn-xs">编辑</a>
                        <a title="删除" href="javascript:;" onclick="del({{$v->goodsId}})" class="btn btn-danger btn-xs">删除</a> -->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float:right">
            {{$data->links()}}
        </div>
    </div>
@endsection