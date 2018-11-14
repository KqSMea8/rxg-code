@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active">商品分类</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <div style="margin-bottom: 1%">
        <span>
            <table width="100%">
                <tr class="row">
                    <td class="col-md-3">
                        <a href="{{url('admin/product/add_category')}}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-plus"></i> 添加新分类
                        </a>
                        <a href="{{url('admin/product/recycleBin')}}" class="btn btn-warning btn-sm">
                            进入回收站
                        </a>
                    </td>
                    <td class="col-md-9">
                    </td>
                </tr>
            </table>
        </span>
        </div>
        <table class="table-hover table table-bordered">
            <thead>
            <tr>
                <th>id</th>
                <th>分类名称</th>
                <th>是否显示</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$v)
                <tr>
                    <td><input type="checkbox" value="{{$v['catId']}}" class="fu" />{{$v['catId']}}</td>
                    <td>@if ($v['parentId']==0)
                            {{$v['catName']}}
                        @else
                    <?php echo str_repeat('|—',substr_count($v['path'],'-'))?>{{$v['catName']}}
                        @endif
                    </td>
                   
                    <td>@if ($v['isShow']==1)
                            <img src="{{URL::asset('img/yes.gif')}}"/>
                        @else
                            <img src="{{URL::asset('img/no.gif')}}"/>
                        @endif</td>
                    <td>
                        <a href="{{URL::asset('admin/product/category_hui')}}?id={{$v['catId']}}" title="放入回收站" class="btn btn-primary btn-xs">放入回收站</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <label id="quan" class="btn btn-primary btn-xs" isChecked='1'>全选</label>
        <input type="button" value="批量删除" id="pi" class="btn btn-danger btn-xs"/>
                    <div style="float:right">
                    {{$data->links()}}
        </div>
    </div>
    <script>
        $(document).on("click", "#quan", function () {
            var xuan = $(this).attr('isChecked')
            var BoxLength = $("input:checkbox").length;
            var status = '';
            if (xuan==1) {
                status = true;
                $(this).attr('isChecked',2);
                $('#quan').text('全不选')
            }else
            {
                status = false;
                $(this).attr('isChecked',1);
                $('#quan').text('全选')
            }
            
            for(var i = 0;i < BoxLength;i++)
            {
                $("input:checkbox")[i].checked = status;
            }
        })



        $(document).on("click", "#pi", function () {
            var ids = []
            var suo = $("input:checked")
            $.each(suo, function (k, v) {
                ids.push(v.value)
            })

            $.ajax({
                url: "{{URL::asset('admin/product/category_pi')}}",
                data: {ids: ids},
                success: function (res) {
                    console.log(res)
                    if (res == 1) {
                        location.href = "{{URL::asset('admin/product/productCategory')}}"
                    }
                }
            })
        })

        $(document).on('click','.fu',function(){
              var xuan = $(this).val();  
              var fuxuan = $(".fu").prop('checked')
              var SonLength = $('input[data="son-'+xuan+'"]').length;
             for(var i = 0 ;i < SonLength;i++){
                if (fuxuan==true) {
                  {
                   $('input[data="son-'+xuan+'"]')[i].checked = true
                  }
                }else{
                    $('input[data="son-'+xuan+'"]')[i].checked = false
                }

            }
              
        })

        $(document).on('click','.son',function(){
            var val = $(this).attr("data"); 
            var len = $(this).parent("td").children("input").length
            var chlen = $(this).parent("td").children("input:checked").length;
            var td1 = $(this).parents("tr").children("td").eq(0)
            if(len == chlen){
                td1.children("input").prop("checked",true);
            }else{
                td1.children("input").prop("checked",false);
            }


              
        })




    </script>
@endsection