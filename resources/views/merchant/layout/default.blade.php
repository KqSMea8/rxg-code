<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>任性购商家后台</title>

    <!-- Bootstrap core CSS -->
    <link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    <!--external css-->
    <link href="{{URL::asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/zabuto_calendar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/gritter/css/jquery.gritter.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/lineicons/style.css')}}">

    <!-- Custom styles for this template -->
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/style-responsive.css')}}" rel="stylesheet">

    <script src="{{URL::asset('assets/js/chart-master/Chart.js')}}"></script>
    <script src="{{URL::asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{URL::asset('layer/layer.js')}}"></script>
    <link rel="stylesheet" href="{{URL::asset('layer/mobile/need/layer.css')}}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body style="background-color: #fff;">

<section id="container">
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg" style="background-color: #68dff0">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="隐藏菜单"></div>
        </div>
        <!--logo start-->
        <a href="javascript:;" class="logo"><b>任性购商家后台</b></a>
        <!--logo end-->
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li>
                    <a class="logout" href="{{url('merchant/login/loginOut')}}" title="退出登录">
                        <i class="glyphicon glyphicon-log-out"></i>退出
                    </a>
                </li>
            </ul>
        </div>
    </header>
    <!--header end-->

    <!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
    *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse" style="width:12%">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
                <p class="centered">
                    <a href="javascript:;">
                        <img src="{{URL::asset(session()->get('shopInfo')->shopImg)}}" class="img-circle" width="60">
                    </a>
                </p>
                <h5 class="centered">{{session()->get('shopInfo')->shopName}}</h5>

                <li class="sub-menu" style="margin-left:0px;margin-right:0px">
                    <a href="javascript:;">
                        <i class="fa fa-cogs" style="margin-left:10%" ></i>
                        <span>店铺信息</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('merchant/index/index')}}" style="margin-left:20%">店铺信息</a></li>
                    </ul>
                </li>
                <li class="sub-menu" style="margin-left:0px;margin-right:0px">
                    <a href="javascript:;">
                        <i class="glyphicon glyphicon-shopping-cart" style="margin-left:10%"></i>
                        <span>商品管理</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('merchant/goods/goodsList')}}" style="margin-left:20%">商品列表</a></li>
                    </ul>
                </li>
                <li class="sub-menu" style="margin-left:0px;margin-right:0px">
                    <a href="javascript:;">
                        <i class="glyphicon glyphicon-comment" style="margin-left:10%"></i>
                        <span>商品评论</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('merchant/comment/comment')}}" style="margin-left:20%">商品评论</a></li>
                    </ul>
                </li>
                <li class="sub-menu" style="margin-left:0px;margin-right:0px">
                    <a href="javascript:;">
                        <i class="glyphicon glyphicon-comment" style="margin-left:10%"></i>
                        <span>物流管理</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('merchant/logistics/logisticslist')}}" style="margin-left:20%">物流信息</a>

                        </li>
                   </ul>
                </li>
                <li class="sub-menu" style="margin-left:0px;margin-right:0px">
                    <a href="javascript:;">
                        <i class="glyphicon glyphicon-list-alt" style="margin-left:10%"></i>
                        <span>订单管理</span>
                    </a>
                    <ul class="sub">
                        <li>
                            <a href="{{url('merchant/order/order')}}" style="margin-left:20%">订单列表</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
</section>
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
***********************************
************************************************************************************************************************* -->
<!--main content start-->
<section style="padding-top: 50px;">
    <div class="pull-right" style="width:88%">
        @yield('content')
    </div>
    <!-- /.col -->
</section>
<!--main content end-->


<!-- js placed at the end of the document so the pages load faster -->
<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{URL::asset('assets/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.scrollTo.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.nicescroll.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/jquery.sparkline.js')}}"></script>


<!--common script for all pages-->
<script src="{{URL::asset('assets/js/common-scripts.js')}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/js/gritter/js/jquery.gritter.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/gritter-conf.js')}}"></script>

<!--script for this page-->
<script src="{{URL::asset('assets/js/sparkline-chart.js')}}"></script>
<script src="{{URL::asset('assets/js/zabuto_calendar.js')}}"></script>
</body>
</html>
