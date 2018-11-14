<?php
use Illuminate\Support\Facades\Redis;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>任性购后台管理</title>


    <!-- Bootstrap core CSS -->
    <link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    <!--external css-->
    <link href="{{URL::asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/zabuto_calendar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/gritter/css/jquery.gritter.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/lineicons/style.css')}}">
    <script language="javascript" type="text/javascript" src="{{URL::asset('js/WdatePicker.js')}}"></script>
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

<section id="container" style="width:100%">
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg" style="background-color: #68dff0">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="隐藏菜单"></div>
        </div>
        <!--logo start-->
        <a href="{{url('admin/index')}}" class="logo"><b>任性购后台管理</b></a>
        <!--logo end-->
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
               
                <!-- <font style="font-size:20px;float:left;padding-right:20px;margin-top:15px;">今日访问量为:{{Redis::PFCOUNT(date('Y-m-d'))}}</font> -->
                
                <li>
                    <a class="logout" href="{{url('admin/login/loginOut')}}" title="退出登录">
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
                        <img src="{{URL::asset('assets/img/ui-sam.jpg')}}" class="img-circle" width="50">
                    </a>
                </p>
                <h5 class="centered">{{session()->get('adminInfo')}}</h5>
                @foreach(session()->get('menu') as $k=>$v)
                    <li class="sub-menu" style="margin-left:0px;margin-right:0px;">
                        <a class="{{(session()->get('activeId')==$v['powerId'])?'active':''}}" href="javascript:;" style="padding-left: 30px">
                            <span><?=$v['powerName']?></span>
                        </a>
                        <ul class="sub">
                            @foreach($v['child'] as $key=>$val)
                                <li style="padding-left: 10px">
                                    <span class="text-right" style="display: inline-block;width: 30%">
                                        <i class="{{(session()->get('currentCheck')==$val['powerId'])?'glyphicon glyphicon-record':''}}"></i>
                                    </span>
                                    <a href="{{url($val['powerUrl'])}}"
                                       style="display: inline;">{{$val['powerName']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
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
    <div class="pull-right" style="width:88%;">
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
