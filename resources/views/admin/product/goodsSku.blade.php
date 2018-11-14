@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #num::-webkit-textfield-decoration-container {
  
}    
#num::-webkit-inner-spin-button {
   -webkit-appearance: none;
}
#num::-webkit-outer-spin-button {
   -webkit-appearance: none;
}
 
        #price::-webkit-textfield-decoration-container {
  
}    
#price::-webkit-inner-spin-button {
   -webkit-appearance: none;
}
#price::-webkit-outer-spin-button {
   -webkit-appearance: none;
}
        
        
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li><a href="{{url('admin/product/productList')}}">商品列表</a></li>
        <li class="active">添加sku</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form id="form" method="post" enctype="multipart/form-data" action="{{url('admin/product/skuAttr')}}">
            <table>
                {{csrf_field()}}
                <tr>
                    <td class="col-lg-2 text-right">商品名称：</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" value="{{$goods['goodsName']}}" class="form-control" disabled/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">总库存：</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="stock" class="form-control" value="{{$goods['goodsStock']}}" disabled=""/></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">剩余库存：</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="elseStock" class="form-control" value="{{$goods['goodsStock']-$num}}" disabled=""/></td>
                </tr>
                <tr>
                    <td  class="col-lg-2 text-right">销售属性：</td>
                    <td  class="col-lg-6 input-group-sm">
                        @foreach($attributes as $k=>$v)
                        <dl class="dl-horizontal dl_box" style="margin-left: -95px">
                                <dt>
                                    {{$v->attrName}}：
                                </dt>
                                <dd>
                                    @foreach($v->attrValue as $key=>$val)
                                    <input type="radio" name="{{$v->attrId}}" value="{{$val->id}}" required="required">{{$val->avName}}
                                    @endforeach
                                </dd>
                            </dl>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">库存：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="number" name="num" class="form-control" onkeyup="checkNum()" required="" id="num"   />
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">sku价格：</td>
                    <td class="col-lg-6 input-group-sm"><input type="number" name="skuPrice" class="form-control" required="" id="price"/></td>
                </tr>
               <tr>
                    <td class="col-lg-2 text-right">商品品牌：</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="brandId" id="" class="form-control" disabled="">
                                <option value="{{$brand['brandId']}}">{{$brand['brandName']}}</option>
                        </select>
                        
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/product/productList')}}"
                           class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回商品列表</a>
                        <button type="submit" class="btn" style="background-color: #4fd98b;width: 150px"  id="addSku"><i class="glyphicon glyphicon-plus"></i>添加sku</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
    function checkNum()
        {
            var num=$("[name='num']").val();
            var str="/^[1-9]d*$/";
            var elseStock=parseInt($("[name='elseStock']").val());
            
                
            if(num!='')
            {
                num = parseInt($("[name='num']").val());
                if(num<=elseStock)
                {
                       

                }
                else
                {
                    layer.msg("sku库存不能大于剩余库存",
                    {
                        time:2000,
                        icon:2
                    })
                }
                
            }
                        

            
        }
        
        //添加sku
        $("#addSku").on("click",function(e){
            e.preventDefault();
            var attr_values="";
            var attrbutes = @json("$attributes");
            
            $(JSON.parse(attrbutes)).each(function(k,v){
                attr_values+=','+$("input:checked[name='"+v.attrId+"']").val();
            })
            attr_values = attr_values.substr(1);
            var num=$("input[name='num']").val();
            var price=$("input[name='skuPrice']").val();
            var goodsId="{{$goods['goodsId']}}";
            $.ajax({
                 headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                 url:"{{url('admin/product/skuAttr')}}",
                 data:{attr_values:attr_values,num:num,price:price,goodsId:goodsId},
                 dataType:'json',
                 type:'post',
                 success:function(data){
                     if(data.code===1)
                     {
                            layer.msg("添加成功",{
                                time:2000,
                                icon:1
                            });
                            history.go(0);
                     }
                     if(data.code===2)
                     {
                         layer.msg("已经为该商品添加属性",{
                             time:2000,
                             icon:2
                             
                         })
                     }
                     
                     
                 }
            })
            
            
            
            

        })
        
        
        
//        {{--action="{{url('admin/product/add_product_do')}}"--}}
//        $("button[type='submit']").on('click',function (e){
//            e.preventDefault();
//            var data = new FormData($("#form")[0]);
//            $.ajax({
//                url:"{{url('admin/product/add_product_do')}}",
//                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
//                dataType:'json',
//                type:'post',
//                data:data,
//                cache: false,
//                processData: false,
//                contentType: false,
//                success:function (res) {
//                    if(res.code == 2){
//                        layer.msg(res.message,{
//                            time:1000,
//                            icon:res.code
//                        });
//                    }else{
//                       layer.msg(res.message,{
//                            time:1000,
//                            icon:res.code
//                        },function () {
//                            window.location.href="{{url('admin/product/productList')}}";
//                        });
//                    }
//
//                }
//            })
//        })
//
//
//    </script>
@endsection
