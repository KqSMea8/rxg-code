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
            <span style="font-size: 16px;"><em>子分类添加</em></span>
            <span class="pull-right">
            </span>
        </div>
        <form action="{{URL::asset('admin/product/add_category_son_do')}}" method="post">
            {{csrf_field()}}
            <table>
                <tr>
                    <td class="col-lg-2 text-right">父级分类名称</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="parentId" class="form-control">
                            <option value="">--请选择--</option>
                           @foreach($data as $k=>$v)
                                <option value="{{$v->catId}}">{{$v->catName}}</option>
                            @endforeach
                        </select></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">子分类名称</td>
                    <td class="col-lg-6 input-group-sm"><input type="text" name="catName" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">是否展示：</td>
                    <td class="col-lg-6 input-group-sm">
                       <input type="radio" name="isShow" value="1" class='textBox'/>是
                      <input type="radio" name="isShow" value="0" class='textBox'/>否
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-4 input-group-sm text-center">
                       <a href="{{url('admin/product/productCategory')}}"
                   class="btn btn-warning" style="width:150px;"><i class="glyphicon glyphicon-hand-left"></i>返回分类列表</a>
   <input type="submit" value="添加子分类" class="btn" style="background-color: #4fd98b;width: 150px"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
@endsection