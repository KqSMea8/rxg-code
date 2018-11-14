@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">品牌管理</a></li>
        <li><a href="{{url('admin/brand/brandList')}}">品牌列表</a></li>
        <li class="active">品牌添加</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form id="form" method="post" enctype="multipart/form-data">
            <table style="width: 100%">
                {{csrf_field()}}
                <tr>
                    <td class="col-lg-2 text-right">品牌名称</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="brandName" class="form-control"/></td>
                    <td class="col-lg-4 input-group-sm"></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">品牌图片</td>
                    <td class="col-lg-6 input-group-sm"><input type="file" name="brandImg"/></td>
                </tr>
               <tr>
                    <td class="col-lg-2 text-right">品牌描述</td>
                    <td class="col-lg-6 input-group-sm"><textarea name="brandDesc" id="" cols="30" rows="10" class="form-control" style="height: 100px;"></textarea></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">品牌状态</td>
                    <td class="col-lg-6 input-group-sm">

                        <input type="radio" name="status" value="1" />可用
                        <input type="radio" name="status" value="0" />不可用
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">选择分类</td>
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
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-4 input-group-sm text-center">
                    <a href="{{url('admin/brand/brandList')}}"
                   class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回品牌列表</a>
                        <button type="submit" class="btn" style="background-color: #4fd98b;width: 150px"><i class="glyphicon glyphicon-plus"></i>添加品牌</button></td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $("button[type='submit']").on('click',function (e){
            e.preventDefault();
            var data = new FormData($("#form")[0]);
            $.ajax({
                url:"{{url('admin/brand/addDo')}}",
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
                            window.location.href="{{url('admin/brand/brandList')}}";
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