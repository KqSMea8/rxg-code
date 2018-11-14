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
    <li><a href="{{url('admin/attribute/attrList')}}">属性列表</a></li>
    <li class="active">属性修改</li>
</ol>
    <div class="container" style="margin-top: 2%">
  <form id="form" method="post" enctype="multipart/form-data" >
{{csrf_field()}}

  <table style="width: 100%">
  <input type="hidden" name="attrId"  value="{{$attrInfo['attrId']}}" />
      <tr>
          <td class="col-lg-2 text-right">属性名称</td>
          <td class="col-lg-6 input-group-sm">
              <input type="text" name="attrName" class="form-control" value="{{$attrInfo['attrName']}}"/></td>
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
              <select name="goodsCatId" class="form-control" style="width: 150px;display: inline;" onchange="getBrand(this.value)">
                  <option value="">--请选择--</option>
                  @foreach($catList3 as $k=>$v)
                      <option value="{{$v['catId']}}" {{($v['catId']==$attrInfo['goodsCatId'])?'selected':''}}>{{$v['catName']}}</option>
                  @endforeach
              </select>
          </td>
          <td class="col-lg-4 input-group-sm"></td>
      </tr>
      <tr>
          <td class="col-lg-2 text-right">属性类型</td>
          <td class="col-lg-6 input-group-sm">
              <input type="radio" name="attrType" value="0" {{($attrInfo['attrType']==0)?'checked':''}}/>基本属性（规格）
              <input type="radio" name="attrType" value="1" {{($attrInfo['attrType']==1)?'checked':''}}/>销售属性
          </td>
      </tr>
      <tr>
          <td class="col-lg-2 text-right">是否展示</td>
          <td class="col-lg-6 input-group-sm">

              <input type="radio" name="isShow" value="1" {{($attrInfo['isShow']==1)?'checked':''}}/>展示
              <input type="radio" name="isShow" value="0" {{($attrInfo['isShow']==0)?'checked':''}}/>不展示
          </td>
      </tr>
      <tr>
          <td class="col-lg-2 text-right">属性状态</td>
          <td class="col-lg-6 input-group-sm">

              <input type="radio" name="status" value="1" {{($attrInfo['status']==1)?'checked':''}}/>可用
              <input type="radio" name="status" value="0" {{($attrInfo['status']==0)?'checked':''}}/>不可用
          </td>
      </tr>
      <tbody id="attrValue">
      @foreach($attrValue as $k=>$v)
      <tr>
          <td class="col-lg-2 text-right">{{($k===0)?'属性值（多）':''}}</td>
          <td class="col-lg-6 input-group-sm">
              <input type="text" name="avName[]" class="form-control" value="{{$v['avName']}}"/>
          </td>
          <td class="col-lg-6 input-group-sm">
              <a href="javascript:;" data-toggle="tooltip" data-placement="right"
                 title="删除" onclick="delAttrValue(this)">
                  <i class="glyphicon glyphicon-minus"></i>
              </a>
              @if($k===count($attrValue)-1)
                  <a href="javascript:;" data-toggle="tooltip" data-placement="right" title="点击增加属性值" onclick="addAttrValue(this)">
                      <i class="glyphicon glyphicon-plus"></i>
                  </a>
              @endif
          </td>
      </tr>
      @endforeach
      </tbody>
    <tr>
        <td class="col-lg-2 text-right"></td>
        <td class="col-lg-4 input-group-sm text-center">
            <a href="{{url('admin/attribute/attrList')}}" class="btn btn-warning" style="width:150px">
                <i class="glyphicon glyphicon-hand-left"></i>返回属性列表</a>
            <button type="submit" id="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                <i class='glyphicon glyphicon-plus'>确认修改</i>
            </button>
        </td>
    </tr>
  </table>
  </form>
    </div>
<script>
   
//表单
$("button[type='submit']").on('click',function (e){
    e.preventDefault();
    var data = new FormData($("#form")[0]);
    $.ajax({
        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
        url:"{{url('admin/attribute/attrEdit')}}",
        dataType:'json',
        type:'post',
        data:data,
        cache: false,
        processData: false,
        contentType: false,
        success:function (res) {
            if(res.code === 1){
                layer.msg(res.message,{
                    time:1000,
                    icon:res.code,
                },function () {
                    window.location.href="{{url('admin/attribute/attrList')}}";
                });
            }else{
                layer.msg(res.message,{
                    time:1000,
                    icon:res.code
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
    if(name!='goodsCatId'){
        $(own).next().css('display','inline');
        $(own).next().next().css('display','none');
        $(own).next().html(str);
        $(own).next().next().html('<option value="">--请选择--</option>');
    }
}
function addAttrValue(own) {
    var attrrValueObj = $("[name='avName[]']");
    var num = 0;
    attrrValueObj.each(function (k,v) {
        if($(v).val()==''){
            num++;
        }
    });
    if(num<1){
        var str = '<tr>\
                    <td class="col-lg-2 text-right"></td>\
                    <td class="col-lg-6 input-group-sm">\
                    <input type="text" name="avName[]" class="form-control"/>\
                    </td>\
                    <td class="col-lg-6 input-group-sm">\
                    <a href="javascript:;" data-toggle="tooltip" data-placement="right" title="删除" onclick="delAttrValue(this)">\
                    <i class="glyphicon glyphicon-minus"></i>\
                    </a>\
                    <a href="javascript:;" data-toggle="tooltip" data-placement="right" title="点击增加属性值" onclick="addAttrValue(this)">\
                    <i class="glyphicon glyphicon-plus"></i>\
                    </a>\
                    </td>\
                    </tr>';
        var str1 = '<a href="javascript:;" data-toggle="tooltip" data-placement="right" title="删除" onclick="delAttrValue(this)">\
                    <i class="glyphicon glyphicon-minus"></i>\
                    </a>';
        $(own).parent().html(str1);
        $("#attrValue").append(str);
    }else{
        layer.msg('请填写完整属性框',{
            time:2000,
            icon:2
        });
    }
}
function delAttrValue(own) {
    var trNum = $("#attrValue tr").length;
    if(trNum>2){
        var str = '<a href="javascript:;" data-toggle="tooltip" data-placement="right" title="删除" onclick="delAttrValue(this)">\
                    <i class="glyphicon glyphicon-minus"></i>\
                    </a>\
                <a href="javascript:;" data-toggle="tooltip" data-placement="right" title="点击增加属性值" onclick="addAttrValue(this)">\
                    <i class="glyphicon glyphicon-plus"></i>\
                    </a>';
    }else{
        var str = '<a href="javascript:;" data-toggle="tooltip" data-placement="right" title="点击增加属性值" onclick="addAttrValue(this)">\
                    <i class="glyphicon glyphicon-plus"></i>\
                    </a>';
    }
    $(own).parent().parent().remove();
    $("#attrValue").children().children().last().html(str);
}
</script>
@endsection