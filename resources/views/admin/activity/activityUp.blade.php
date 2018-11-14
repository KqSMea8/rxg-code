@extends('admin.layout.default')
@section('content')
    <style>
        table tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #div1{
            position:relative;
        }
        ul li a{
            text-decoration:none;
            color: #000000;
        }
        #groupid{
            width: 430px;
            -moz-border-radius: 3px; 
            -webkit-border-radius: 3px;
            border-radius:3px; 
            background-color: #FFFFFF;
            border: 1px solid #ddd;
            font-size: 16px;
            line-height: 30px;
            border-bottom: 1px solid #ddd;
            padding-left: 5px;

        }
        #div2{
            position:absolute; top:35px; left:0px;
            z-index: 999;
        }
    </style>
     <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.js"></script>
    <div class="container" style="margin-top: 2%;">
        <div class="page-title" style="margin-bottom: 1%">
            <span style="font-size: 16px;"><em>活动修改</em></span>
        </div>
        <form action="{{url('admin/activity/activityUpdate')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <table>
              <input type="hidden" name="id"  value="{{$activity['id']}}" />
                <tr>
                    <td class="col-lg-2 text-right">活动名称：</td>
                    <td class="col-lg-6 input-group-sm">
                        <input type="text" class="form-control" name="activityName" value="{{$activity['activityName']}}" required="required"/>
                    </td>
                </tr>
                 <tr>
                    <td class="col-lg-2 text-right">商品分类</td>
                    <td class="col-lg-6 input-group-sm">
                        <select name="catId" id="catName" class="form-control">
                            <option value="">请选择分类</option>
                            @foreach($cat as $k=>$v)
                            <option value="{{$v->catId}}" {{($v->catId==$activity['catId'])?'selected':''}} >{{$v->catName}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">活动商品：</td>
                    <td class="col-lg-6 input-group-sm">
                        <div id='div1'>
                          <input class="form-control"  type="text" placeholder="请填写活动商品名称" id="js-groupId" autocomplete="off"  required="required" value="{{$activity['goodsName']}}">
                        <input type="hidden" name='goodsId' value="{{$activity['goodsId']}}">
                         
                        <div style="height:0px;padding:0px" id='div2' type='hidden'>
                            <ul id="groupid" style="display: none">
                            
                            </ul>
                        </div>
                    </div>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">活动时间：</td>
                    <td class="col-lg-6 input-group-sm demo">
                        <input type="text" id="config-demo" name='time' class="form-control" value="{{$activity['sTime'].' - '.$activity['oTime']}}">
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">活动描述</td>
                    <td class="col-lg-6 input-group-sm"><textarea required="required" id="" cols="30" rows="10" class="form-control" name='activityDesc' style='height:50px'>{{$activity['activityDesc']}}</textarea></td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">活动类型：</td>
                    <td class="col-lg-6 input-group-sm">
                         <input type="radio" name="activityClass" value="1" checked>分享优惠
                         <input type="radio"  name="activityClass" value="2" >分享返利
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right">优惠价</td>
                    <td class="col-lg-6 input-group-sm">
                         <input type="text" name="favourable" value="{{$activity['favourable']}}" required="required" />元  
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 text-right"></td>
                    <td class="col-lg-6 input-group-sm text-center">
                        <a href="{{url('admin/activity/activityList')}}" class="btn btn-warning" sty="width:150px">
                            <i class="glyphicon glyphicon-hand-left"></i>返回活动列表
                        </a>
                        <input type="submit"  value="修改" class="btn" style="background-color: #4fd98b;width: 150px"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">
            $(function(){
                var goods = @json($goods);
                var str = '';
                $(goods["{{$activity['catId']}}"]).each(function(k,v){
                    str+='<li value="'+v['goodsId']+'"><a href="javascript:void(0)">'+v['goodsName']+'</a></li>';
                })
                $("#groupid").html(str);
            });
            $("#catName").change(function(){
             var catId = $(this).val();
            var goods = @json($goods);
            var str = '';
            $(goods[catId]).each(function(k,v){
                str+='<li value="'+v['goodsId']+'"><a href="javascript:void(0)">'+v['goodsName']+'</a></li>';
            })
            $("#groupid").html(str);
        })

        //时间
     var beginTimeTake;
            
            $('#config-demo').daterangepicker({
                singleDatePicker: false,
                showDropdowns: true,
                autoUpdateInput: true,
                timePicker24Hour : true,
                timePicker : true,
                "locale": {
                    format: 'YYYY-MM-DD HH:mm',
                    applyLabel: "应用",
                    cancelLabel: "取消",
                    resetLabel: "重置",
                }
            }, 
            function(sTime, oTime, label) {
                beginTimeTake = sTime;
                if(!this.sTimeDate){
                    this.element.val('');
                }else{
                    this.element.val(this.sTimeDate.format(this.locale.format));
                }
            });


             //模糊查询
   jQuery.expr[':'].Contains = function (a, i, m) {
        return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };
    function filterList(list) {
        $('#js-groupId').bind('input propertychange', function () {
            var filter = $(this).val();
            if (filter) {
                $matches = $(list).find('a:Contains(' + filter + ')').parent();
                $('li', list).not($matches).slideUp();
                $matches.slideDown();
            } else {
                $(list).find("li").slideDown();
            }
        });
    }
    $(function () {
        filterList($("#groupid"));
        $('#js-groupId').bind('blur', function () {
            $('#groupid').slideUp();
        })
        $('#groupid').on('click', 'li', function () {
            $('#js-groupId').val($(this).text())
            $('input[name="goodsId"]').val($(this).attr('value'))
            $('#groupId').val($(this).data('id'))
            $('#groupid').slideUp()
        });
    })
    $("#js-groupId").on('keyup',function(){
        $('ul#groupid').empty(); 
        var goodsId = $(this).val();
        var catId = $("#catName").val();
        var goods = @json($goods);
        var str = '';
        var num = 0;
        $(goods[catId]).each(function(k,v){
            if(v['goodsName'].indexOf(goodsId)>-1 && num<5){
                str+='<li value="'+v['goodsId']+'"  z-index="90"><a href="javascript:void(0)" style=" text-decoration: none;">'+v['goodsName']+'</a></li>';
                num+=1;
            }
        })
        $("#groupid").html(str);
        $('ul#groupid').show(); 
    })
    </script>
@endsection