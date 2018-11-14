<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
    <meta name="renderer" content="webkit">
    <title>注册.任性购</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/home.css')}}">
    <link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}">
</head>
<body>

<header id="pc-header">
    <div class="center">
        <div class="pc-fl-logo">
            <a href="{{url('/')}}">
                <img src="{{URL::asset('img/logo.png')}}" alt="">
            </a>
        </div>
    </div>
</header>
<section>
    <div class="pc-login-bj">
        <div class="center clearfix">
            <div class="fl"></div>
            <div class="fr pc-login-box">
                <div class="pc-login-title">
                    <h2>
                        手机号注册
                        <a href="javascript:;" class="red" style="font-size: 10px" onclick="toEmail()">
                            或邮箱注册
                        </a>
                    </h2>
                </div>
                <form class="layui-form" id="form">
                    {{csrf_field()}}
                    <div class="pc-sign" id="accountId">
                        <input type="text" placeholder="请输入您的手机号" autocomplete="off" name="tel" onblur="checkTel()">
                    </div>
                    <div class="pc-sign">
                        <input type="password" placeholder="请输入您的密码" name="password" onblur="checkPassword()">
                    </div>
                    <div class="pc-sign">
                        <input type="password" placeholder="请确认您的密码" onblur="checkRpassword()" name="rPassword">
                    </div>
                    <div class="pc-sign" id="code">
                        <input type="password" placeholder="请输入验证码" style="width: 180px" onblur="checkTelCode()"
                               name="telCode">
                        <button class="layui-btn layui-btn-normal" style="height: 42px;float: right" id="getTelCode">
                            获取验证码
                        </button>
                    </div>
                    <div class="pc-submit-ss">
                        <input type="submit" lay-submit lay-filter="telForm" value="立即注册">
                    </div>
                    <div class="pc-reg">
                        <a href="{{url('login/login')}}" class="red">已有账号? 请登录</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<footer>
    <div class="pc-footer-top">
        <div class="center">
            <ul class="clearfix">
                <li>
                    <span>关于我们</span>
                    <a href="#">关于我们</a>
                    <a href="#">诚聘英才</a>
                    <a href="#">用户服务协议</a>
                    <a href="#">网站服务条款</a>
                    <a href="#">联系我们</a>
                </li>
                <li class="lw">
                    <span>购物指南</span>
                    <a href="#">新手上路</a>
                    <a href="#">订单查询</a>
                    <a href="#">会员介绍</a>
                    <a href="#">网站服务条款</a>
                    <a href="#">帮助中心</a>
                </li>
                <li class="lw">
                    <span>消费者保障</span>
                    <a href="#">人工验货</a>
                    <a href="#">退货退款政策</a>
                    <a href="#">运费补贴卡</a>
                    <a href="#">无忧售后</a>
                    <a href="#">先行赔付</a>
                </li>
                <li class="lw">
                    <span>商务合作</span>
                    <a href="#">人工验货</a>
                    <a href="#">退货退款政策</a>
                    <a href="#">运费补贴卡</a>
                    <a href="#">无忧售后</a>
                    <a href="#">先行赔付</a>
                </li>
                <li class="lss">
                    <span>下载手机版</span>
                    <div class="clearfix lss-pa">
                        <div class="fl lss-img"><img src="{{URL::asset('img/phoneAppCode.png')}}" alt=""></div>
                        <div class="fl" style="padding-left:20px">
                            <h4>扫描下载任性购APP</h4>
                            <p>把优惠握在手心</p>
                            <P>把潮流带在身边</P>
                            <P></P>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="pc-footer-lin">
            <div class="center">
                <p>友情链接：
                    卡宝宝信用卡
                    梦芭莎网上购物
                    手游交易平台
                    法律咨询
                    深圳地图
                    P2P网贷导航
                    名鞋库
                    万表网
                    叮当音乐网
                    114票务网
                    儿歌视频大全
                </p>
                <p>
                    京ICP证1900075号 京ICP备20051110号-5 京公网安备110104734773474323 统一社会信用代码 91113443434371298269B
                    食品流通许可证SP1101435445645645640352397
                </p>
                <p style="padding-bottom:30px">版物经营许可证 新出发京零字第朝160018号 Copyright©2011-2015 版权所有 ZHE800.COM </p>
            </div>
        </div>
    </div>
</footer>
<script src="{{URL::asset('bootstrap/jquery.min.js')}}"></script>
<script src="{{URL::asset('layui/layui.js')}}"></script>
<script>
    layui.use(['form', 'layer'], function () {
        var form = layui.form;
        var layer = layui.layer;
        form.on('submit(telForm)', function () {
            if (checkTel() && checkPassword() && checkRpassword() && checkTelCode()) {
                toRegister();
                return false;
            }
            return false;
        });
        form.on('submit(emailForm)', function () {
            if (checkEmail() && checkPassword() && checkRpassword() && checkEmail()) {
                toRegister();
                return false;
            }
            return false;
        })
    });
    function toRegister() {
        var layerLoad = layer.load(2,{
            shade: [0.1,'#fff']
        });
        var formData = $("#form").serialize();
        $.ajax({
            url: "{{url('login/register')}}",
            type: 'post',
            dataType: 'json',
            data: formData,
            success: function (res) {
                layer.close(layerLoad);
                if (res.code === 1) {
                    layer.msg(res.message, {
                        time: 2000,
                        icon: 1
                    });
                    location.href="{{url('login/login')}}";
                } else {
                    layer.msg(res.message, {
                        time: 2000,
                        icon: 2
                    });
                }
            }
        });
    }
    $(function () {
        toEmail();
        var telCodeTime = "{{session()->get('telCodeTime')}}";
        if ((telCodeTime - (parseInt(Date.parse(new Date())) / 1000)) >= 0) {
            var intervalO = setInterval(function () {
                var nowTime = parseInt(Date.parse(new Date())) / 1000;
                if ((telCodeTime - nowTime) < 0) {
                    clearInterval(intervalO);
                    $("#code #getTelCode").prop('disabled', false);
                    $("#code #getTelCode").text('获取验证码');
                } else {
                    $("#code #getTelCode").prop('disabled', true);
                    $("#code #getTelCode").text((telCodeTime - nowTime) + '秒后再次发送');
                }
            }, 1000);
        }
        var emailCodeTime = "{{session()->get('emailCodeTime')}}";
        if ((emailCodeTime - (parseInt(Date.parse(new Date())) / 1000)) >= 0) {
            var intervalE = setInterval(function () {
                var nowTime = parseInt(Date.parse(new Date())) / 1000;
                if ((emailCodeTime - nowTime) < 0) {
                    clearInterval(intervalE);
                    $("#code #getEmailCode").prop('disabled', false);
                    $("#code #getEmailCode").text('获取验证码');
                } else {
                    $("#code #getEmailCode").prop('disabled', true);
                    $("#code #getEmailCode").text((emailCodeTime - nowTime) + '秒后再次发送');
                }
            }, 1000);
        }
    });
    //发送手机验证码
    $("#code").on('click', '#getTelCode', function (e) {
        e.preventDefault();
        var tel = $("#accountId input:text").val();
        var telRes = checkTel();
        if (telRes === true) {
            $.ajax({
                url: "{{url('login/codeTimePut')}}",
                data:{type:'telCodeTime'},
                type: 'get',
                async: false,
                success: function (res) {
                    console.log(res)
                }
            });
            var telCodeTime = parseInt(Date.parse(new Date())) / 1000 + 60;
            var intervalO = setInterval(function () {
                var nowTime = parseInt(Date.parse(new Date())) / 1000;
                if ((telCodeTime - nowTime) < 0) {
                    clearInterval(intervalO);
                    $("#code #getTelCode").prop('disabled', false);
                    $("#code #getTelCode").text('获取验证码');
                } else {
                    $("#code #getTelCode").prop('disabled', true);
                    $("#code #getTelCode").text((telCodeTime - nowTime) + '秒后再次发送');
                }
            }, 1000);
            $.ajax({
                url: "{{url('login/sendMessage')}}",
                data: {tel: tel},
                type: 'get',
                dataType: 'json',
                async: false,
                success: function (res) {
                    console.log(res)
                }
            })
        }
    });
    //发送邮箱验证码
    $("#code").on('click', '#getEmailCode', function (e) {
        e.preventDefault();
        var email = $("#accountId input:text").val();
        var emailRes = checkEmail();
        if (emailRes === true) {
            $.ajax({
                url: "{{url('login/codeTimePut')}}",
                type: 'get',
                data:{type:'emailCodeTime'},
                async: false,
                success: function (res) {
                    console.log(res)
                }
            });
            var emailCodeTime = parseInt(Date.parse(new Date())) / 1000 + 60;
            var intervalO = setInterval(function () {
                var nowTime = parseInt(Date.parse(new Date())) / 1000;
                if ((emailCodeTime - nowTime) < 0) {
                    clearInterval(intervalO);
                    $("#code #getEmailCode").prop('disabled', false);
                    $("#code #getEmailCode").text('获取验证码');
                } else {
                    $("#code #getEmailCode").prop('disabled', true);
                    $("#code #getEmailCode").text((emailCodeTime - nowTime) + '秒后再次发送');
                }
            }, 1000);
            $.ajax({
                url:"{{url('login/sendEmail')}}",
                data:{email:email},
                type:'get',
                dataType:'json',
                async:false,
                success:function (res) {
                    console.log(res)
                }
            })
        }
    });

    //验证手机号格式
    function checkTel() {
        var tel = $("[name='tel']").val();
        if (tel === '') {
            layer.tips('手机号不能为空', "[name='tel']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            return false;
        } else if (/^1\d{10}$/.test(tel)) {
            return true;
        } else {
            layer.tips('手机号格式不正确', "[name='tel']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            return false;
        }
    }

    //验证邮箱
    function checkEmail() {
        var email = $("[name='email']").val();
        if (email === '') {
            layer.tips('邮箱不能为空', "[name='email']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            return false;
        } else if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) {
            return true;
        } else {
            layer.tips('邮箱格式不正确', "[name='email']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            return false;
        }
    }

    //验证密码
    function checkPassword() {
        var password = $("[name='password']").val();
        if (password === '') {
            layer.tips('密码不能为空', "[name='password']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            return false;
        } else if (/^\w{8,16}$/.test(password)) {
            return true;
        } else {
            layer.tips('密码必须为8-16位的字符', "[name='password']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            return false;
        }
    }

    //验证重复密码
    function checkRpassword() {
        var rPassword = $("[name='rPassword']").val();
        var password = $("[name='rPassword']").parent().prev().children().val();
        if (rPassword !== password) {
            layer.tips('两次输入密码不符', "[name='rPassword']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            return false;
        } else {
            return true;
        }
    }

    //检测手机验证码
    function checkTelCode() {
        var telCode = $("[name='telCode']").val();
        var result = false;
        if (telCode === '') {
            layer.tips('验证码不能为空', "[name='telCode']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            result = false;
        } else if ((parseInt(Date.parse(new Date())) / 1000) - parseInt("{{session()->get('telCodeTime')}}") > 240) {
            layer.tips('验证码已过期', "[name='telCode']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            result = false;
        } else {
            $.ajax({
                url: "{{url('login/checkCode')}}",
                data: {code: telCode},
                type: 'get',
                dataType: 'json',
                async: false,
                success: function (res) {
                    if (res.code === 1) {
                        result = true;
                    } else {
                        layer.tips('验证码错误', "[name='telCode']", {
                            tips: [1, '#f00'], //还可配置颜色
                            time: 1000
                        });
                        result = false;
                    }
                }
            });
        }
        return result;
    }

    //检测邮箱验证码
    function checkEmailCode() {
        var emailCode = $("[name='emailCode']").val();
        var result = false;
        if (emailCode === '') {
            layer.tips('验证码不能为空', "[name='emailCode']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            result = false;
        } else if ((parseInt(Date.parse(new Date())) / 1000) - parseInt("{{session()->get('codeTime')}}") > 240) {
            layer.tips('验证码已过期', "[name='telCode']", {
                tips: [1, '#f00'], //还可配置颜色
                time: 1000
            });
            result = false;
        } else {
            $.ajax({
                url: "{{url('login/checkCode')}}",
                data: {code: emailCode},
                type: 'get',
                dataType: 'json',
                async: false,
                success: function (res) {
                    if (res.code === 1) {
                        result = true;
                    } else {
                        layer.tips('验证码错误', "[name='telCode']", {
                            tips: [1, '#f00'], //还可配置颜色
                            time: 1000
                        });
                        result = false;
                    }
                }
            });
        }
        return result;
    }

    function toEmail() {
        $("div.pc-login-title h2").html('邮箱注册\
            <a href="javascript:;" class="red" style="font-size: 10px" onclick="toTel()">\
            或手机号注册\
            </a>\
            ');
        $("#accountId").html('<input type="text" placeholder="请输入您的邮箱" autocomplete="off" name="email" onblur="checkEmail()">');
        $("#code").html('<input type="password" placeholder="请输入验证码" style="width: 180px" onblur="checkEmailCode()" name="emailCode">\n' +
            '                        <button class="layui-btn layui-btn-normal" style="height: 42px;float: right" id="getEmailCode">获取验证码</button>');
        $("input:submit").attr('lay-filter', 'emailForm');
    }

    function toTel() {
        $("div.pc-login-title h2").html('手机号注册\
            <a href="javascript:;" class="red" style="font-size: 10px" onclick="toEmail()">\
            或邮箱注册\
            </a>\
            ');
        $("#accountId").html('<input type="text" placeholder="请输入您的手机号" autocomplete="off" name="tel" onblur="checkTel()">');
        $("#code").html('<input type="password" placeholder="请输入验证码" style="width: 180px" onblur="checkTelCode()" name="telCode">\n' +
            '                        <button class="layui-btn layui-btn-normal" style="height: 42px;float: right" id="getTelCode">获取验证码</button>');
        $("input:submit").attr('lay-filter', 'telForm');
    }
</script>
</body>
</html>