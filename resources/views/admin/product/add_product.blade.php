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
        <li class="active">商品添加</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form id="form" method="post" enctype="multipart/form-data">
            <table style="width: 100%">
                {{csrf_field()}}
                <tr>
                    <td class="col-lg-2 text-right">商品名称</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="goodsName" class="form-control"/></td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品图片</td>
                    <td class="col-lg-6 input-group-sm"><input type="file" name="goodsImg" /></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">市场价</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="marketPrice" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">门市价</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="shopPrice" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">预警库存</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="warnStock" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品总库存</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="goodsStock" class="form-control"/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择商品分类</td>
                    <td class="col-lg-6 input-group-sm" id="cat">
                        <select class="form-control" style="width: 150px;display: inline;margin-right: 20px" onchange="catChange(this)">
                            <option value="">--请选择--</option>
                            @foreach($parentCat as $k=>$v)
                                <option value="{{$v['catId']}}">{{$v['catName']}}</option>
                            @endforeach
                        </select>
                        <select class="form-control" style="width: 150px;display:none;margin-right: 20px" onchange="catChange(this)">
                            <option value="">--请选择--</option>
                        </select>
                        <select name="catId" class="form-control" style="width: 150px;display: none" onchange="getBrand(this.value)">
                            <option value="">--请选择--</option>
                        </select>
                    </td>
                </tr>
                <tr style="display: none" id="goodsSpec">
                    <td class="col-lg-2 text-right">选择商品基本属性（规格）</td>
                    <td class="col-lg-6 input-group-sm"></td>
                </tr>
                 <tr>
                    <td class="col-lg-2 text-right">选择商铺</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="shopId" id="" class="form-control">
                            <option value="">--请选择--</option>
                            @foreach($shop as $k=>$v)
                                <option value="{{$v['shopId']}}">{{$v['shopName']}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择品牌</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="brandId" id="" class="form-control">
                            <option value="">--请先选择分类--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否上架</td>
                    <td class="col-lg-6 input-group-sm">

                        <input type="radio" name="isSale" value="1" checked/>是
                        <input type="radio" name="isSale" value="0" />否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否精品</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isBest" value="1"  checked/>是
                        <input type="radio" name="isBest" value="0"  />否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否热销商品</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isHot" value="1" checked/>是
                        <input type="radio" name="isHot" value="0" />否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否推荐</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="radio" name="isRecom" value="1"  checked/>是
                        <input type="radio" name="isRecom" value="0"  />否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">商品描述</td>
                    <td class="col-lg-6 input-group-sm"><textarea name="goodsDesc" id="" cols="30" rows="10" class="form-control" style="height: 100px;"></textarea></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">促销信息</td>
                    <td class="col-lg-6 input-group-sm"><textarea name="goodsTips" id="" cols="30" rows="10" class="form-control" style="height: 100px;"></textarea></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-4 input-group-sm text-center">
                    <a href="{{url('admin/product/productList')}}"
                   class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回商品列表</a>
                        <button type="submit" class="btn" style="background-color: #4fd98b;width: 150px"><i class="glyphicon glyphicon-plus"></i>添加商品</button></td>
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
                if(v.goodsCatId==catId){
                    goodsSpecStr += ','+$("input:checked[name='"+v.attrId+"']").val();
                }
            });
            goodsSpecStr = goodsSpecStr.substr(1);
            var data = new FormData($("#form")[0]);
            data.append('goodsSpec',goodsSpecStr);
            $.ajax({
                url:"{{url('admin/product/add_product_do')}}",
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
            var catList = @json($goodscats);
            var str = '<option value="">--请选择--</option>';
            $(catList).each(function (k,v) {
                if(v.parentId==parentId){
                    // console.log(v);
                    str+='<option value="'+v.catId+'">'+v.catName+'</option>';
                }
            });
            if(name!='catId'){
                $(own).next().css('display','inline');
                $(own).next().next().css('display','none');
                $(own).next().html(str);
                $(own).next().next().html('<option value="">--请选择--</option>');
                $("[name='brandId']").html('<option value="">--请先选择分类--</option>');
                $("#goodsSpec").hide();
                $("#goodsSpec").children().next().text('');
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
