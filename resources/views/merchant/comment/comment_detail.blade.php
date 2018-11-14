@extends('merchant.layout.default')
@section('content')
    <style>
        .table tbody tr td {
            vertical-align: middle;
        }
    </style>
    <div class="container" style="margin-top: 2%;">
        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><i></i><em>商品评论回复</em></span>
        </div>
        <form action="#" id="form" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label" style="text-align:right;">回复列表</label>
                <div class="col-sm-8" id="reply_list">
                    @foreach($data as $key => $value)
                        <div class="list_div">
                            <p>【{{$value->created_time}}&nbsp;@if($value->type == 1)用户@else店铺@endif
                                ：】&nbsp;{{$value->content}}</p>
                        </div>
                    @endforeach
                </div>
                <div class="clearfix" style="margin-bottom: 2em;"></div>
            </div>
            <input type="hidden" id="comment_id" value="{{$comment_id}}">
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-2" style="padding-left:50px">
                    <button type="button" id="info_button" onclick="addreply();" class="btn btn-primary"
                            style="width:90px;margin-right:30px;float:left">添加回复
                    </button>

                    <button type="button" id="info_cancle" class="btn btn-primary back-page"
                            style="width:60px;margin-right:30px;float:left">返回
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $("#info_cancle").on('click',function () {
            history.go(-1);
        })
        function addreply() {
            var reply_list = $("#reply_list");
            var comment_id = $("#comment_id").val();
            layer.prompt({
                formType: 2,
                title: '发送回复',
                offset: '150px',
                area: ['500px', '300px'] //自定义文本域宽高
            }, function (value, index, elem) {
                if (value == "") {
                    layer.msg('回复不能为空');
                } else {
                    layer.load(1);
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                        url: "{{url('merchant/comment/commentReplyAdd')}}",
                        dataType: "JSON",
                        data: {content: value, comment_id: comment_id},
                        type: "post",
                        success: function (data) {
                            if (data.code == 1) {
                                var msg = "<div class='list_div'>\
                                    <p>【"+data.created_time+"&nbsp;店铺：】&nbsp;"+data.content+"</p >\
                                </div>";
                                reply_list.append(msg);
                                layer.msg('回复成功', {icon: 6, time: 1000}, function () {
                                    layer.closeAll();
                                });
                            } else {
                                layer.msg(data.msg, {icon: 5}, function () {
                                    layer.closeAll('loading');
                                });
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            layer.msg('出错啦', {icon: 5}, function () {
                                layer.closeAll('loading');
                            });
                        }
                    });

                }

            });

        }
    </script>
@endsection