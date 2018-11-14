@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li><a href="{{url('admin/product/productList')}}">商品列表</a></li>
        <li class="active">商品修改</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form action="{{url('product/product_update_do')}}" method="post" enctype="multipart/form-data" id="form">
            <table style="width: 100%">
                {{csrf_field()}}
                <tr>
                    <input type="hidden" name="goodsId" value="{{$goods['goodsId']}}">
                    <td class="col-lg-2 text-right">商品名称</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="goodsName"
                                                               value="{{$goods['goodsName']}}" class="form-control"/>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品图片</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="file" name="goodsImg" />
                        <img src="{{URL::asset($goods['goodsImg'])}}" alt="" height="50">原始图片
                        <input type="hidden"  value="{{$goods['goodsImg']}}" name="oldImgSrc">
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">市场价</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="marketPrice"
                                                               value="{{$goods['marketPrice']}}" class="form-control"/>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">门市价</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="shopPrice"
                                                               value="{{$goods['shopPrice']}}" class="form-control"/>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">预警库存</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="warnStock"
                                                               value="{{$goods['warnStock']}}" class="form-control"/>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品总库存</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="goodsStock"
                                                               value="{{$goods['goodsStock']}}" class="form-control"/>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择商品分类</td>
                    <td class="col-lg-6 input-group-sm" id="cat">
                        <select class="form-control" style="width: 150px;display: inline;margin-right: 20px" onchange="catChange(this)" id="cat1">
                            <option value="">--请选择--</option>
                            @foreach($catList1 as $k=>$v)
                                <option value="{{$v['catId']}}" {{($v['catId']==$parentId2['parentId'])?'selected':''}}>{{$v['catName']}}</option>
                            @endforeach
                        </select>
                        <select class="form-control" style="width: 150px;display: inline;margin-right: 20px" onchange="catChange(this)" id="cat2">
                            <option value="">--请选择--</option>
                            @foreach($catList2 as $k=>$v)
                                <option value="{{$v['catId']}}" {{($v['catId']==$parentId3['parentId'])?'selected':''}}>{{$v['catName']}}</option>
                            @endforeach
                        </select>
                        <select name="catId" class="form-control" style="width: 150px;display: inline;" onchange="getBrand(this.value)">
                            <option value="">--请选择--</option>
                            @foreach($catList3 as $k=>$v)
                                <option value="{{$v['catId']}}" {{($v['catId']==$goods['catId'])?'selected':''}}>{{$v['catName']}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr id="goodsSpec">
                    <td class="col-lg-2 text-right">选择商品基本属性（规格）</td>
                    <td class="col-lg-6 input-group-sm">
                        @foreach($catSpec as $k=>$v)
                            <dl class="dl-horizontal dl_box" style="margin-left: -95px">
                                <dt>
                                    {{$v->attrName}}：
                                </dt>
                                <dd>
                                    @foreach($v->attrValue as $key=>$val)
                                        <input type="radio" name="{{$v->attrId}}" value="{{$val->id}}" required="required" {{(in_array($val->id,$goodsSpecValue))?'checked':''}}>{{$val->avName}}
                                    @endforeach
                                </dd>
                            </dl>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择店铺</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="shopId" id="" class="form-control">
                            <option value="">--请选择--</option>
                        @foreach($shops as $k=>$v)
                                <option value="{{$v['shopId']}}" {{($v->shopId==$goods['shopId'])?'selected':''}}>{{$v['shopName']}}</option>
                            @endforeach
                        </select></td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择品牌</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="brandId" id="" class="form-control">
                            <option value="">--请先选择分类--</option>
                            @foreach($catBrand as $k=>$v)
                                <option value="{{$v['brandId']}}" {{($v['brandId']==$goods['brandId'])?'selected':''}}>{{$v['brandName']}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否上架</td>
                    <td class="col-lg-6 input-group-sm">
                        @if($goods['isSale']==1)
                            <input type="radio" name="isSale" value="{{$goods['isSale']}}" checked/>是
                            <input type="radio" name="isSale" value="{{$goods['isSale']}}"/>否
                        @else
                            <input type="radio" name="isSale" value="{{$goods['isSale']}}"/>是
                            <input type="radio" name="isSale" value="{{$goods['isSale']}}" checked/>否
                        @endif
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否精品</td>
                    <td class="col-lg-6 input-group-sm">
                        @if($goods['isBest']==1)
                            <input type="radio" name="isBest" value="{{$goods['isBest']}}" checked/>是
                            <input type="radio" name="isBest" value="{{$goods['isBest']}}"/>否
                        @else
                            <input type="radio" name="isBest" value="{{$goods['isBest']}}"/>是
                            <input type="radio" name="isBest" value="{{$goods['isBest']}}" checked/>否
                        @endif
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否热销商品</td>
                    <td class="col-lg-6 input-group-sm">
                        @if($goods['isHot']==1)
                            <input type="radio" name="isHot" value="{{$goods['isHot']}}" checked/>是
                            <input type="radio" name="isHot" value="{{$goods['isHot']}}"/>否
                        @else
                            <input type="radio" name="isHot" value="{{$goods['isHot']}}"/>是
                            <input type="radio" name="isHot" value="{{$goods['isHot']}}" checked/>否
                        @endif
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否推荐</td>
                    <td class="col-lg-6 input-group-sm">
                        @if($goods['isSale']==1)
                            <input type="radio" name="isRecom" value="{{$goods['isRecom']}}" checked/>是
                            <input type="radio" name="isRecom" value="{{$goods['isRecom']}}"/>否
                        @else
                            <input type="radio" name="isRecom" value="{{$goods['isRecom']}}"/>是
                            <input type="radio" name="isRecom" value="{{$goods['isRecom']}}" checked/>否
                        @endif
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品描述</td>
                    <td class="col-lg-6 input-group-sm"><textarea name="goodsDesc" id="" cols="30" rows="10"
                                                                  class="form-control" style="height: 100px;">{{$goods['goodsDesc']}}</textarea>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">促销信息</td>
                    <td class="col-lg-6 input-group-sm"><textarea name="goodsTips" id="" cols="30" rows="10" class="form-control" style="height: 100px;">{{$goods['goodsTips']}}</textarea></td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/product/productList')}}"
                           class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回商品列表</a>
                        <button type="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                            <i class="glyphicon glyphicon-plus"></i>修改商品信息
                        </button>
                    </td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $("button[type='submit']").on('click',function (e){
            e.preventDefault();
            $("#goodsSpec input").prop('disabled',true);
            var catId = $("[name='catId']").val();
            var goodsSpec = @json($goodsSpec);
            var goodsSpecStr = '';
            $(goodsSpec).each(function (k,v) {
                if(v.goodsCatId==catId) {
                    goodsSpecStr += ',' + $("input:checked[name='" + v.attrId + "']").val();
                }
            });
            goodsSpecStr = goodsSpecStr.substr(1);
            var data = new FormData($("#form")[0]);
            data.append('goodsSpec',goodsSpecStr);
            $.ajax({
                url:"{{url('admin/product/product_update_do')}}",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                dataType:'json',
                type:'post',
                data:data,
                cache: false,
                processData: false,
                contentType: false,
                success:function (res) {
                    if(res.code == 2){
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        });
                    }else{
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        },function () {
                            window.location.href="{{url('admin/product/productList')}}";
                        });
                    }

                }
            })
        });
        function catChange(own) {
            var name = $(own).prop('name');
            var parentId = $(own).val();
            var catList = @json($catList);
            var str = '<option value="">--请选择--</option>';
            $(catList).each(function (k,v) {
                if(v.parentId==parentId){
                    str+='<option value="'+v.catId+'">'+v.catName+'</option>';
                }
            });
            if(name!='catId'){
                $(own).next().css('display','inline');
                $(own).next().next().css('display','none');
                $(own).next().html(str);
                $(own).next().next().html('<option value="">--请选择--</option>');
                // $("[name='brandId']").html('<option value="">--请先选择分类--</option>');
                // $("#goodsSpec").hide();
                // $("#goodsSpec").children().next().text('');
            }
        }
        function getBrand(catId) {
            var brand = @json($brandList);
            var brandStr = '<option value="">--请选择--</option>';
            $(brand).each(function(k,v){
                if(v.catId==catId){
                    brandStr+='<option value="'+v.brandId+'">'+v.brandName+'</option>';
                }
            });
            $("[name='brandId']").html(brandStr);
            getSpec(catId);
        }
        function getSpec(catId){
            $("#goodsSpec").show();
            var goodsSpec = @json($goodsSpec);
            var specStr = '';
            $(goodsSpec).each(function (k,v) {
                if(v.goodsCatId==catId){
                    var specValStr = '';
                    $(v.attrValue).each(function (key,val) {
                        specValStr+=' <input type="radio" name="'+v.attrId+'" value="'+val.id+'">'+val.avName;
                    });
                    specStr+='\
                    <dl class="dl-horizontal dl_box" style="margin-left: -95px">\
                        <dt>'+v.attrName+'：</dt>\
                        <dd>'+specValStr+'</dd>\
                    </dl>';
                }
            });
            $("#goodsSpec").children().next().html(specStr);
        }
    </script>
@endsection