@extends('admin.layout.default')
@section('content')
<ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active"><a href="{{url('admin/product/productList')}}">商品列表</a></li>
        <li class="active">查看sku</li>
    </ol>

<a href="{{url('admin/product/goodsSku')}}?id={{$goodsId}}" class="btn btn-warning btn-sm" style="margin-left: 20px;">
    <i class="glyphicon glyphicon-plus"></i> 添加SKU
</a>
                    
<table class="table-hover table table-bordered" style="margin-top: 10px;">
            <thead>
            <tr class="active">
                <th>SkuId</th>
                <th>销售属性</th>
                <th>商品价格</th>
                <th>sku剩余库存</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$v)
                <tr>
                    
                    <td>{{$v["id"]}}</td>
                    <td>
                        @foreach($v["attr_values"] as $key=>$val)
                        {{$val["attrName"]}}:
                        {{$val['avName']}},
                        
                        @endforeach
                        
                    </td>
                    <td>{{$v["price"]}}</td>
                    <td style="text-align:center">{{$v["num"]}}</td>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-danger btn-xs"  onclick="skudelete({{$v['id']}})">删除</a>
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
<script>
    function skudelete(id){
        
        $.ajax({
            url:"{{url('admin/product/deleteSku')}}",
            data:{id:id},
            dataType:'json',
            type:'get',
            success:function(data){
               if(data.code===1)
               {
                   layer.msg(data.message,{
                       time:2000,
                        icon:1
                       
                   })
                   history.go(0)
               }
               if(data.code===2)
               {
                   layer.msg(data.message,{
                       time:2000,
                        icon:2
                       
                   })
               }
                
            }
            
            
        })
        
        
    }

</script>


@endsection
