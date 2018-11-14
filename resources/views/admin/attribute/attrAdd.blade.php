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
        <li class="active">属性添加</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form id="form" method="post" enctype="multipart/form-data">
            <table style="width: 100%">
                {{csrf_field()}}
                <tr>
                    <td class="col-lg-2 text-right">属性名称</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="attrName" class="form-control"/></td>
                    <td class="col-lg-4 input-group-sm"></td>
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
                        <select name="goodsCatId" class="form-control" style="width: 150px;display: none" onchange="getBrand(this.value)">
                            <option value="">--请选择--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">属性类型</td>
                    <td class="col-lg-6 input-group-sm">

                        <input type="radio" name="attrType" value="0" checked/>基本属性（规格）
                        <input type="radio" name="attrType" value="1" />销售属性
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否展示</td>
                    <td class="col-lg-6 input-group-sm">

                        <input type="radio" name="isShow" value="1" checked/>展示
                        <input type="radio" name="isShow" value="0" />不展示
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">属性状态</td>
                    <td class="col-lg-6 input-group-sm">

                        <input type="radio" name="status" value="1" checked/>可用
                        <input type="radio" name="status" value="0" />不可用
                    </td>
                </tr>
                <tbody id="attrValue">
                <tr>
                    <td class="col-lg-2 text-right">属性值（多）</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" name="avName[]" class="form-control"/>
                    </td>
                    <td class="col-lg-6 input-group-sm">
                        <a href="javascript:;" data-toggle="tooltip" data-placement="right"
                           title="点击增加属性值" onclick="addAttrValue(this)">
                            <i class="glyphicon glyphicon-plus"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-4 input-group-sm text-center">
                    <a href="{{url('admin/attribute/attrList')}}"
                   class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回属性列表</a>
                        <button type="submit" class="btn" style="background-color: #4fd98b;width: 150px"><i class="glyphicon glyphicon-plus"></i>添加属性</button></td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $(function () {
            $("[data-toggle='tooltip']").tooltip();
        });
        $("button[type='submit']").on('click',function (e){
            e.preventDefault();
            var data = new FormData($("#form")[0]);
            $.ajax({
                url:"{{url('admin/attribute/attrAdd')}}",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                dataType:'json',
                type:'POST',
                data:data,
                cache: false,
                processData: false,
                contentType: false,
                success:function (res) {
                    if(res.code === 2){
                        layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        });
                    }else{
                       layer.msg(res.message,{
                            time:1000,
                            icon:res.code
                        },function () {
                            window.location.href="{{url('admin/attribute/attrList')}}";
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
            if(name!='goodsCatId'){
                $(own).next().css('display','inline');
                $(own).next().next().css('display','none');
                $(own).next().html(str);
                $(own).next().next().html('<option value="">--请选择--</option>');
            }
        };
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