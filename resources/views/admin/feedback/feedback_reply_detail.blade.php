@extends('admin.layout.default')
@section('content')
    <style>
        .table tbody tr td {
            vertical-align: middle;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">意见反馈</a></li>
        <li><a href="{{url('admin/feedback/feedBack')}}">意见反馈列表</a></li>
        <li class="active">意见反馈回复</li>
    </ol>
    <div class="container" style="margin-top: 2%;">
        <form action="#" id="form" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label" style="text-align:right;">回复列表</label>
                <div class="col-sm-8" id="reply_list">
                    @foreach($feedback_reply_list as $key => $value)
                        <div class="list_div">
                            <p>【{{$value->created_time}}&nbsp;@if($value->type == 1)用户@else系统@endif
                                ：】&nbsp;{{$value->content}}</p>
                        </div>
                    @endforeach
                </div>
                <div class="clearfix" style="margin-bottom: 2em;"></div>
            </div>
            <input type="hidden" id="feed_id" value="{{$feedback_id}}">
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-2" style="padding-left:50px">
                    <button type="button" id="info_button" onclick="addreply();" class="btn btn-primary"
                            style="width:90px;margin-right:30px;float:left">添加回复
                    </button>

                    <a href="{{url('admin/feedback/feedBack')}}" class="btn btn-primary back-page"
                            style="width:60px;margin-right:30px;float:left">返回
                    </a>
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
            var feed_id = $("#feed_id").val();
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
                        url: "{{url('admin/feedback/feedbackReplyAdd')}}",
                        dataType: "JSON",
                        data: {content: value, feedback_id: feed_id},
                        type: "post",
                        success: function (data) {
                            if (data.code == 1) {
                                reply_list.append(data.msg);
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