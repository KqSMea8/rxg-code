<body>
<link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/base.css')}}">
<link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/home.css')}}">
<link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}">
<header id="pc-header">
    <div class="center">
        <div class="pc-fl-logo">
            <img src="{{URL::asset('img/logo.png')}}" alt="">
        </div>
    </div>
</header>
<section>
    <div class="pc-login-bj">
        <div class="center clearfix">
            <div class="fr pc-login-box" style="width: 100%;height: 100px;padding-top: 80px">
                <h1 style="text-align: center">
                    您正在使用邮箱注册，您的邮箱验证码是
                    <font size="6" color="red">{{$code}}</font>，
                    请在5分钟内进行验证！
                </h1>
            </div>
        </div>
    </div>
</section>
</body>