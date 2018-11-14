@extends('admin.layout.default')
@section('content')
<style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
          <div class="container" style="margin-top: 2%;">
        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><em>分类添加</em></span>
            <span class="pull-right">
            </span>
        </div>
     <form action="{{URL::asset('admin/product/add_category_do')}}" method="post">
     {{csrf_field()}}
                            <table>
                             <tr>
                    <td class="col-lg-2 text-right">分类名称：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" placeholder="请填写分类名称" name="catName"/>
                    </td>
                </tr>
                <tr id="parentCats">
                    <td class="col-lg-2 text-right">选择上级分类：</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="parentId" class="form-control" id="parent_cats">
                            <option value="">--请选择--</option>
                            <option value="0">顶级分类</option>
                            @foreach($goodscats as $k=>$v)
                                <option value="{{$v->catId}}">
                                  <?php echo $v->catName?>
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr style='display:none' id="childCat">
                    
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否展示：</td>
                    <td class="col-lg-6 input-group-sm">
                    <input type="radio" name="isShow" value="1" class="textBox"/>是
                    <input type="radio" name="isShow" value="0" class="textBox"/>否
                    </td>
                </tr>
                <tr>
                   <td class="col-lg-2 text-right"></td>
                   <td class="col-lg-4 input-group-sm text-center">
                    <a href="{{url('admin/product/productCategory')}}"
                                   class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回分类列表</a>
                   <input type="submit" value="添加新分类" class="btn" style="background-color: #4fd98b;width: 150px"/></td>
                </tr>
            </table>      
        </form>
</div>
<script>
    $(document).on('change','#parent_cats',function(){
        var parentId = $(this).val()
        $.ajax({
            url:"{{url('admin/product/addCategoryShowParentId')}}",
            headers:{'X-CSRF-TOKEN':"{{csrf_token()}}"},
            type:'get',
            data:{parentId:parentId},
            dataType:'json',
            success:function(res){
                if (res.code==3) {
                    $('#childCat').empty()
                    layer.msg(res.message,{
                        time:1000,
                        icon:res.code
                    })
                }
                if (res.code==4) {
                    $('#childCat').empty()
                    layer.msg(res.message,{
                        time:1000,
                        icon:res.code
                    })
                }
                if (res.code==1) {
                    var tr = '';
                    $.each(res.data,function(k,v){
                        tr+="<option value='"+v.catId+"'>"+v.catName+"</option>";
                    });
                    var str = "<td class='col-lg-2 text-right'>选择二级分类：</td><td class='col-lg-6 input-group-sm'><select name='towCatId'id='' class='form-control'><option value=''>请选择</option>"+tr+"</select></td>";
                    $("#childCat").show();
                    $("#childCat").html(str);
                }
            }
        })
    })
</script>
  @endsection

