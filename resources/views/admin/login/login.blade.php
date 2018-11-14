<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>任性购后台管理</title>
    <link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/style-responsive.css')}}" rel="stylesheet">
    <script src="{{URL::asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{URL::asset('layer/layer.js')}}"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>
<body>
<div id="login-page">
    <div class="container">
        <form id="form" class="form-login" action="{{url('admin/login/login_do')}}" method="post">
            {{csrf_field()}}
            <h2 class="form-login-heading">欢迎登录任性购后台管理</h2>
            <div class="login-wrap">
                <input type="text" name="adminName" class="form-control" placeholder="请输入账号" autofocus>
                <br>
                <input type="password" name="password" class="form-control" placeholder="请输入密码">
                <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="javascript:;">忘记密码？</a>
		                </span>
                </label>
                <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> 登录</button>
            </div>
        </form>
    </div>
</div>
<script src="{{URL::asset('assets/js/jquery.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/jquery.backstretch.min.js')}}"></script>
<script>
    $.backstretch("{{URL::asset('assets/img/login-bg.jpg')}}", {speed: 500});
    $('button[type="submit"]').on('click', function (e) {
        e.preventDefault();
        var formData = $("#form").serialize();
        $.ajax({
            type: "post",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "{{url('admin/login/loginDo')}}",//url
            data: formData,
            success: function (res) {
                if (parseInt(res.code) === 2) {
                    layer.msg(res.message, {
                        time: 1000,
                        icon: res.code
                    });
                } else {
                    location.href = "{{url('admin/index')}}";
                }
            }
        })
    })
</script>
</body>
</html>
