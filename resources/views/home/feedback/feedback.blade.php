@extends('home.left.left')
@section('left')
    <div class="member-right fr">
        <div class="member-feedbackhead">
            <div><h2>意见反馈</h2></div>
            <div style="width:970px;height:370px;">
                <center>
                    <form method="post">
                        {{csrf_field()}}
                        <h2>意见内容</h2>
                        <input type="hidden" name="userId" value="{{$userId}}">
                        <p><textarea name="content" id="" cols="100" rows="7"></textarea></p>
                        <p><input type="button" onclick="addfeedback();" value="发表意见反馈"></p>
                    </form>
                </center>
            </div>
        </div>
    </div>
    </div>
    </section>
    <script>
        function addfeedback() {
            var userId = $("input[name='userId']").val();
            var content = $("textarea[name='content']").val();
            if (!userId) {
                layer.msg('请登录！', {icon: 5, time: 1000});
                location.href = '{{url('login/login')}}';
                return
            }
            if (!content) {
                layer.msg('请添加数据！');
            } else {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    url: "{{url('feedback/addFeedback')}}",
                    data: {userId: userId, content: content},
                    type: 'POST',
                    success: function (res) {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 6, time: 1000});
                        } else {
                            layer.msg(res.msg, {icon: 5, time: 1000});
                        }
                    }
                })
            }
        }
    </script>
@endsection