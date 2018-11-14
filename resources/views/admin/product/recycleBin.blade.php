@extends('admin.layout.default')
@section('content')
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品管理</a></li>
        <li class="active">商品回收站</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <table class="table-striped table table-bordered">
            <tr>
                <th>ID编号</th>
                <th>名称</th>
                <th>删除时间</th>
                <th>操作</th>
            </tr>
            @foreach($data as $k=>$v)
                <tr>
                    <td>
                        <input type="checkbox" value="{{$v->catId}}"/>
                        {{$v->catId}}
                    </td>
                    <td>
                        <span>{{$v->catName}}</span>
                    </td>
                    <td>
                        <span>{{$v->addTime}}</span>
                    </td>
                    <td>
                        <a href="{{URL::asset('admin/product/product_yesHui')}}?id={{$v->catId}}" title="恢复"
                           class="btn btn-primary btn-xs">恢复</a>
                        <a href="{{URL::asset('admin/product/product_yesDel')}}?id={{$v->catId}}" title="彻底删除"
                           class="btn btn-danger btn-xs">彻底删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <label id="quan" class="btn btn-primary btn-xs">全选</label>
        <input type="button" value="批量删除" id="pidel" class="btn btn-danger btn-xs"/>
        <input type="button" value="批量恢复" id="pihui" class="btn btn-primary btn-xs"/>
        <div style="float:right">
            {{$data->links()}}
        </div>
    </div>

    <script>
        $(document).on("click", "#quan", function () {
            var xuan = $(this).attr('isChecked')
            var BoxLength = $("input:checkbox").length;
            var status = '';
            if (xuan == 1) {
                status = true;
                $(this).attr('isChecked', 2);
                $('#quan').text('全不选')
            } else {
                status = false;
                $(this).attr('isChecked', 1);
                $('#quan').text('全选')
            }

            for (var i = 0; i < BoxLength; i++) {
                $("input:checkbox")[i].checked = status;
            }
        })

        $(document).on("click", "#pidel", function () {
            var ids = []
            var suo = $("input:checked")
            $.each(suo, function (k, v) {
                ids.push(v.value)
            })
            $.ajax({
                url: "{{URL::asset('admin/product/recycle_piDel')}}",
                data: {ids: ids},
                success: function (res) {
                    if (res == 1) {

                        console.log(res)
                    }
                }
            })
        })

        // $(document).on("click","#pihui",function(){
        //     var ids = []
        //     var suo = $("input:checked")
        //     $.each(suo,function(k,v){
        //       ids.push(v.value)
        //     })
        //     $.ajax({
        //       url:"{{URL::asset('admin/product/recycle_piHui')}}",
        //       data:{ids:ids},
        //       success:function(res){
        //         if (res==1) {
        //
        //         }
        //       }
        //     })
        // })
    </script>
@endsection