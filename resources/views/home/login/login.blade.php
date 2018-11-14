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
    <title>登录.任性购</title>
    <link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('home/css/home.css')}}">
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
                <div class="pc-login-title"><h2>用户登录</h2></div>
                <form id="form" class="layui-form" method="post">
                    {{csrf_field()}}
                    <div class="pc-sign">
                        <input type="text" required lay-verify="uRequired" placeholder="用户名/邮箱/手机号" autocomplete="off"
                               name="username">
                    </div>
                    <div class="pc-sign">
                        <input type="password" required lay-verify="pRequired" placeholder="请输入您的密码" name="password">
                    </div>
                    <div class="pc-submit-ss">
                        <input type="submit" value="登录" lay-submit lay-filter="formDemo">
                    </div>
                    <div class="pc-item-san clearfix" style="text-align: center">
                        <a href="#">
                            <img src="{{URL::asset('img/wxLogin.png')}}">微信登录
                        </a>
                        <a href="{{url('login/qq_login')}}" style="margin-right:0">
                            <img src="{{URL::asset('img/QQlogin.png')}}">QQ登录
                        </a>
                    </div>
                    <div class="pc-reg">
                        <a href="#">忘记密码</a>
                        <a href="{{url('login/register')}}" class="red">免费注册</a>
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
        form.verify({
            'uRequired': [/[\S]+/, '请填写用户名'],
            'pRequired': [/[\S]+/, '请填写密码']
        });
        // form
        //监听提交
        form.on('submit(formDemo)', function () {
            var formData = $("#form").serialize();
            $.ajax({
                url: "{{url('login/login')}}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    if (res.code === 1) {
                        window.location.href="{{url('/')}}";
                    } else {
                        layer.msg(res.message, {
                            time: 2000,
                            icon: 2
                        })
                    }
                }
            });
            return false;
        });
    });
</script>
</body>
</html>