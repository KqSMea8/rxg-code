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
            <span style="font-size: 16px;"><em>商品修改</em></span>
            <span class="pull-right">
                <a href="{{url('merchant/goods/goodsList')}}"
                   class="btn btn-primary btn-xs"><-商品列表</a>
            </span>
        </div>
        <form id="form" method="post" enctype="multipart/form-data">
            <table>
                {{csrf_field()}}
                <tr>
                    <td class="col-lg-2 text-right">商品名称</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="goodsName" value="{{$data->goodsName}}" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品图片</td>
                    <td class="col-lg-6 input-group-sm"><input type="file" name="goodsImg" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">市场价</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="marketPrice" value="{{$data->marketPrice}}" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">门市价</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="shopPrice" value="{{$data->shopPrice}}" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">预警库存</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="warnStock" value="{{$data->warnStock}}" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品总库存</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="goodsStock" value="{{$data->goodsStock}}" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">促销信息</td>
                    <td class="col-lg-6 input-group-sm"><textarea name="goodsTips" id="" cols="30" rows="10" class="form-control">{{$data->goodsTips}}</textarea></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否上架</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isSale" value="1" @if($data->isSale == 1) checked @endif/>是
                        <input type="radio" name="isSale" value="0" @if($data->isSale == 0) checked @endif/>否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否精品</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isBest" value="1" @if($data->isBest == 1) checked @endif/>是
                        <input type="radio" name="isBest" value="0" @if($data->isBest == 0) checked @endif />否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否热销商品</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isHot" value="1" @if($data->isHot == 1) checked @endif/>是
                        <input type="radio" name="isHot" value="0" @if($data->isHot == 0) checked @endif/>否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否推荐</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isRecom" value="1" @if($data->isRecom == 1) checked @endif />是
                        <input type="radio" name="isRecom" value="0" @if($data->isRecom == 0) checked @endif />否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择品牌</td>
                    <td class="col-lg-6 input-group-sm"><select name="brandId" id="" class="form-control">
                            @foreach($brand as $k=>$v)
                                <option value="{{$v['brandId']}}" @if($v->brandId == $data->brandId)selected @endif>{{$v['brandName']}}</option>
                            @endforeach
                        </select></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品描述</td>
                    <td class="col-lg-6 input-group-sm"><textarea name="goodsDesc" id="" cols="30" rows="10" class="form-control">{{$data->goodsDesc}}</textarea></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">总销售量</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="saleNum" value="{{$data->saleNum}}" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否有规格</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isSpec" value="1" @if($data->isSpec == 1) checked @endif />是
                        <input type="radio" name="isSpec" value="0" @if($data->isSpec == 0) checked @endif />否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品相册</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="galleryId" value="{{$data->galleryId}}" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">
                        <input type="hidden" name="goodsId" value="{{$data->goodsId}}">
                    </td>
                    <td class="col-lg-4 input-group-sm text-center">
                        <input type="submit" value="确定" class="btn" style="background-color: #4fd98b;width: 50%"/></td>
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
                url:"{{url('merchant/goods/goodsUpDo')}}",
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
