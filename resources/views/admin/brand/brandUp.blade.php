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
    <li><a href="{{url('admin/brand/brandList')}}">品牌列表</a></li>
    <li class="active">品牌修改</li>
</ol>
    <div class="container" style="margin-top: 2%">
  <form id="form" method="post" enctype="multipart/form-data" >
{{csrf_field()}}

  <table style="width: 100%">
  <input type="hidden" name="brandId"  value="{{$data['brandId']}}" />
  <input type="hidden" name="img" id="image" value="{{$data['brandImg']}}
  ">
    <tr>
        <td class="col-lg-2 text-right">品牌名称:</td>
        <td class="col-lg-6 input-group-sm">
            <input type="text" name="brandName" class="form-control"  value="{{$data['brandName']}}" />
            <!-- required="required" -->
        </td>
        <td class="col-lg-4 input-group-sm"></td>
    </tr>
    <tr>
        <td class="col-lg-2 text-right">品牌图片:</td>
        <td class="col-lg-6 input-group-sm">
            {{--img src="{{URL::asset('img/up.png')}}" id="img" title="添加图片" style="border:1px solid #d2d6de; max-width: 120px;"/>--}}
            <input name="brandImg" id="img" type="file" accept="image/*" class="textBox" />
            <img src="{{URL::asset($data['brandImg'])}}"  width="60" height="60" >
        </td>
    </tr>
    <tr>
        <td class="col-lg-2 text-right">品牌描述:</td>
        <td class="col-lg-6 input-group-sm">
            <textarea  name="brandDesc" cols="30" rows="10" class="form-control" style="height: 100px;">{{$data['brandDesc']}}</textarea>
        </td>
    </tr>
    <tr>
        <td class="col-lg-2 text-right">品牌状态:</td>
        <td class="col-lg-6 input-group-sm">
            <input type="radio" name="status" value="1"{{($data['status'])==1?'checked':''}}>可用
            <input type="radio" name="status" value="0"{{($data['status'])==0?'checked':''}}>不可用
        </td>
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
                      <option value="{{$v['catId']}}" {{($v['catId']==$data['catId'])?'selected':''}}>{{$v['catName']}}</option>
                  @endforeach
              </select>
          </td>
          <td class="col-lg-4 input-group-sm"></td>
      </tr>
    <tr>
        <td class="col-lg-2 text-right"></td>
        <td class="col-lg-4 input-group-sm text-center">
            <a href="{{url('admin/advertising/advertisingList')}}" class="btn btn-warning" style="width:150px">
                <i class="glyphicon glyphicon-hand-left"></i>返回广告列表</a>
            <button type="submit" id="submit" class="btn" style="background-color: #4fd98b;width: 150px">
                <i class='glyphicon glyphicon-plus'>修改</i>
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
        url:"{{url('admin/brand/brandUp')}}",
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
                    icon:res.code,
                },function () {
                    window.location.href="{{url('admin/brand/brandList')}}";
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
    if(name!='catId'){
        $(own).next().css('display','inline');
        $(own).next().next().css('display','none');
        $(own).next().html(str);
        $(own).next().next().html('<option value="">--请选择--</option>');
    }
}
</script>
@endsection