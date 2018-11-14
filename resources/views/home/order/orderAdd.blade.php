@extends('home.layout.layout')
@section('content')
<div class="yHeader">
        <!-- 导航   start  -->
        <div class="yNavIndex">
            <div class="pullDown">
                <h2 class="pullDownTitle"><i class="icon-class"></i>所有商品分类</h2>
                <ul class="pullDownList">
                    @foreach($catList as $k=>$v)
                        <li class="" data-id="{{$k}}">
                            <i class=""></i>
                            <a href="">{{$v['catName']}}</a>
                            <span></span>
                        </li>
                    @endforeach
                </ul>
                <!-- 下拉详细列表具体分类 -->
                <div class="yMenuListCon">
                    @foreach($catList as $k=>$v)
                        <div class="yMenuListConin">
                            <div class="yMenuLCinList">
                                <h3><a href="" class="yListName"></a><a href="" class="yListMore">更多 ></a></h3>
                                <p></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <ul class="yMenuIndex">
                <li><a href="{{url('/')}}">任性购首页</a></li>
                <li><a href="{{url('shop/shops')}}">店铺中心 </a></li>
                <li><a href="{{url('order/index')}}">我的订单</a></li>
                <li><a href="{{url('collect/favoriteGoods')}}">我的收藏</a></li>
            <!--<li><a href="{{url('merchant/register')}}">商家入驻</a></li>-->
            </ul>
        </div>
        <!-- 导航   end  -->
    </div>
    </header>

<div class="center" style="background:#fff">
<!--收货地址body部分开始-->
<div class="border_top_cart">
<script type="text/javascript">
var checkoutConfig = {
addressMatch:'common',
addressMatchVarName:'data',
hasPresales:false,
hasBigTv:false,
hasAir:false,
hasScales:false,
hasGiftcard:false,
totalPrice:244.00,
postage:10, //运费
postFree:true, //活动是否免邮了
bcPrice:150, //计算界值
activityDiscountMoney:0.00, //活动优惠
showCouponBox:0,
invoice:{
NA:"0",
        personal:"1",
        company:"2",
        electronic:"4"
        }
};
var miniCartDisable = true;</script>
<div class="container">
<div class="checkout-box">
<form  id="checkoutForm" action="{{url('order/alipay')}}" method="post">
{{csrf_field()}}
<div class="checkout-box-bd">
    <!-- 地址状态 0：默认选择；1：新增地址；2：修改地址 -->
    <input type="hidden" name="addressState" id="addrState"   value="0">
    <!-- 收货地址 -->   
    <div class="xm-box">
        <div class="box-hd ">
            <h2 class="title" style="display: inline-block;">收货地址</h2>&nbsp;&nbsp;&nbsp;
            <a href="{{url('address/addressAdd')}}"><h2 style="display: inline-block;color: red" class="title">地址管理</h2></a>
            <!---->
        </div>
        <div class="box-bd">

            <div class="clearfix xm-address-list" id="checkoutAddrList">
            @foreach($address as $k=>$v)
                <dl class="item" id="item{{$v->id}}" data-id="{{$v->id}}" onclick="item({{$v->id}})"  style="{{$address_id[0]->address_id==$v->id  ? 'border-color:red' : '' }}  " >   
                    <dt>
                        <strong class="itemConsignee">收件人姓名：{{$v->user_name}}</strong>
                    </dt>
                    <dd>
                        <p class="tel itemTel">收件人电话：{{$v->tell}}</p>
                        <p class="itemRegion">收件人地址：{{$v->provinceName}}{{$v->cityName}}{{$v->distructName}}</p> 

                        <span class="edit-btn J_editAddr">编辑</span>
                    </dd>
                    <dd style="display:none">
                        <input type="radio" name="Checkout[address]" class="addressId"  value="10140916720030323">
                    </dd>
                </dl>
                @endforeach


                <div class="item use-new-addr"   data-state="off" id="formdata"   >
                    <span class="iconfont icon-add"    ><img src="{{URL::asset('home/images/add_cart.png')}}" title="新增地址" /></span>
                </div>
            </div>
            <!--<input type="hidden" name="newAddress[type]" id="newType">
            <input type="hidden" name="newAddress[consignee]" id="newConsignee">
            <input type="hidden" name="newAddress[province]" id="newProvince">
            <input type="hidden" name="newAddress[city]" id="newCity">
            <input type="hidden" name="newAddress[district]" id="newCounty">
            <input type="hidden" name="newAddress[address]" id="newStreet">
            <input type="hidden" name="newAddress[zipcode]" id="newZipcode">
            <input type="hidden" name="newAddress[tel]" id="newTel">
            <input type="hidden" name="newAddress[tag_name]" id="newTag">-->
            <!--点击弹出新增/收货地址界面start-->

            <div class="xm-edit-addr-box" id="address" >
                <div class="bd">
                    <div class="item" style="margin-top:-50px;margin-left: -10px">
                        <label>收货人姓名<span>*</span></label>
                        <input type="text" name="user_name" id="Consignee"  class="input" placeholder="收货人姓名" maxlength="15" autocomplete='off' onblur="checkname()">
                        
                        <p class="tip-msg tipMsg"></p>
                    </div>
                    <input type="hidden" name="user_id" value="{{$data[0]->userId}}" id="user_id" />
                    <input type="hidden" name="order_id" value="{{$data[0]->orderId}}" id="orderId"/>
                    <div class="item" style="float:left">
                        <label>联系电话<span>*</span></label>
                        <input type="tell" name="tell" class="input" id="Telephone" placeholder="11位手机号" autocomplete='off' style="margin-left:-262px;margin-top: 100px;" onblur="phone()">
                        <p class="tel-modify-tip" id="telModifyTip"></p>
                        <p class="tip-msg tipMsg"></p>
                    </div>

                    <div class="item" style="margin-top:40px;">
                        <label>地址<span>*</span></label>
                        <select name="province" id="provinces" class="select-1"  style="height: 27px;margin-top: -6px" onblur="province()"  >
                            <option>请选择省</option>
                            @foreach($area as $k=>$v)

                            <option value="{{$v->id}}" id="provinces">{{$v->areaName}}</option>
                            @endforeach
                        </select>
                        <select name="city"  id="city" class="select-2"  style="height: 27px;margin-top: -6px" onblur="city()">
                            <option>请选择市</option>

                        </select>
                        <select name="distruct"  id="distruct" class="select-3" style="height: 27px;margin-top: -6px" onblur="distruct()" >
                            <option>请选择区/县</option>

                        </select>

                        <textarea   name="street" class="input-area" id="street" placeholder="路名或街道地址，门牌号" style="margin-left:20px;margin-top: 60px;height: 20px;width: 300px"></textarea>

                    </div>
                    <div class="item">
                        <label>邮政编码<span>*</span></label>
                        <input type="text" name="email" id="zipcode" class="input" placeholder="邮政编码"  autocomplete='off' style="margin-left:-10px" onblur="mail()">
                        <p class="zipcode-tip" id="zipcodeTip"></p>
                        <p class="tip-msg tipMsg"></p>
                    </div>
                    <div class="item" style="margin-top:5px">
                        <label>地址标签<span>*</span></label>
                        <input type="text" name="addresstag" id="tag" class="input" placeholder='地址标签：如"家"、"公司"。限5个字内'   />
                        <p class="tip-msg tipMsg"></p>
                    </div>
                </div>
                <div class="ft clearfix" style="margin-top:-6px">
                    <button  type="button"  class="btn btn-lineDake btn-small " id="J_editAddrCancel" onclick="cancelAddres()" >取消</button>
                    <button type="button" class="btn btn-primary  btn-small " id="J_editAddrOk" onclick=" return baocun()" >保存</button>
                </div>
            </div>

            <!--点击弹出新增/收货地址界面end-->
            <div class="xm-edit-addr-backdrop" id="J_editAddrBackdrop">


            </div>
        </div>                </div>
    <!-- 收货地址 END-->
    <div id="checkoutPayment">
        <!-- 支付方式 -->
        <div class="xm-box">
            <div class="box-hd ">
                <h2 class="title">支付方式</h2>
            </div>
            <div class="box-bd">

                <ul id="checkoutPaymentList" class="checkout-option-list clearfix J_optionList" >

                    <li  id="zaixian" class="item selected">
                        <input type="radio" name="pay" value="1" checked  id="zaipay">
                        <p>
                            在线支付                                
                        </p>
                    </li >
                    <li id="huodao" class="">
                        <input type="radio" name="pay" value="0" id="huopay"   >
                        <p>
                            货到付款                                
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 支付方式 END-->
        <div class="xm-box">
            <div class="box-hd ">
                <h2 class="title">配送方式</h2>
            </div>
            <div class="box-bd">
                <ul id="checkoutShipmentList" class="checkout-option-list clearfix J_optionList">
                    <li class="item selected">
                        <input type="radio" data-price="0" name="shipment_id" value="1" id="express">
                        <p>
                            快递配送（免运费）<span></span>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 配送方式 END-->                    <!-- 配送方式 END-->
    </div>
    <!-- 送货时间 -->
    <div class="xm-box">
        <div class="box-hd">
            <h2 class="title">送货时间</h2>
        </div>
        <div class="box-bd">
            <ul class="checkout-option-list clearfix J_optionList">
                <li class="item selected" id="time1"><input type="radio"  name="best_time" value="1" id="goods1" ><p>不限送货时间<span>周一至周日</span></p></li>
                <li class=" " id="time2"><input type="radio"  name="best_time" value="2" id="goods2"><p>工作日送货<span>周一至周五</span></p></li>
                <li class=" " id="time3"><input type="radio"  name="best_time" value="3" id="goods3"><p>双休日、假日送货<span>周六至周日</span></p></li></ul>
        </div>
    </div>
    <!-- 送货时间 END-->
    <!-- 发票信息 -->
    <div id="checkoutInvoice">
        <div class="xm-box">
            <div class="box-hd">
                <h2 class="title">发票信息</h2>
            </div>
            <div class="box-bd">
                <ul class="checkout-option-list checkout-option-invoice clearfix J_optionList J_optionInvoice">
                    <li class="hide">
                        电子个人发票4
                    </li>
                    <li class="item selected" id="info1">
                    <!--<label><input type="radio"  class="needInvoice" value="0" name="Checkout[invoice]">不开发票</label>-->
                        <input type="radio"    checked="checked"  value="4" name="Checkout">
                        <p>电子发票（非纸质）</p>
                    </li>
                    <li class="item " id="info2">
                        <input type="radio"   value="1" name="Checkout">
                        <p>普通发票（纸质）</p>
                    </li>
                </ul>
                <p id="eInvoiceTip" class="e-invoice-tip ">
                    电子发票是税务局认可的有效凭证，可作为售后维权凭据，不随商品寄送。开票后不可更换纸质发票，如需报销请选择普通发票。<a href="#" target="_blank">什么是电子发票？</a>
                </p>
                <div class="invoice-info nvoice-info-1" id="checkoutInvoiceElectronic" style="display:none;">

                    <p class="tip">电子发票目前仅对个人用户开具，不可用于单位报销 ，不随商品寄送</p>
                    <p>发票内容：购买商品明细</p>
                    <p>发票抬头：个人</p>
                    <p>
                        <span class="hide"><input type="radio" value="4" name="Checkout[invoice_type]"   checked="checked"   id="electronicPersonal" class="invoiceType"></span>
                    <dl>
                        <dt>什么是电子发票?</dt>
                        <dd>&#903; 电子发票是纸质发票的映像，是税务局认可的有效凭证，与传统纸质发票具有同等法律效力，可作为售后维权凭据。</dd>
                        <dd>&#903; 开具电子服务于个人，开票后不可更换纸质发票，不可用于单位报销。</dd>
                        <dd>&#903; 您在订单详情的"发票信息"栏可查看、下载您的电子发票。<a href="#" target="_blank">什么是电子发票？</a></dd>
                    </dl>
                    </p>
                </div>
                <div class="invoice-info invoice-info-2" id="checkoutInvoiceDetail"  style="display:none;" >
                    <p>发票内容：购买商品明细</p>
                    <p>
                        发票抬头：请确认单位名称正确,以免因名称错误耽搁您的报销。注：合约机话费仅能开个人发票
                    </p>
                    <ul class="type clearfix J_invoiceType">
                        <li class="hide">
                            <input type="radio" value="0" name="Checkout[invoice_type]" id="noNeedInvoice" >
                        </li>
                        <li class="">
                            <input  class="invoiceType" type="radio" id="commonPersonal" name="Checkout[invoice_type]" value="1" >
                            个人
                        </li>
                        <li class="">
                            <input  class="invoiceType" type="radio" name="Checkout[invoice_type]" value="2" >
                            单位
                        </li>
                    </ul>
                    <div  id='CheckoutInvoiceTitle' class=" hide  invoice-title">
                        <label for="Checkout[invoice_title]">单位名称：</label>
                        <input name="Checkout[invoice_title]" type="text" maxlength="49" value="" class="input"> <span class="tip-msg J_tipMsg"></span>
                    </div>

                </div>

            </div>
        </div>                </div>
    <!-- 发票信息 END-->
</div>
<div class="checkout-box-ft">
    <!-- 商品清单 -->
    <div id="checkoutGoodsList" class="checkout-goods-box">
        <div class="xm-box">
            <div class="box-hd">
                <h2 class="title">确认订单信息</h2>
            </div>
            <div class="box-bd">
                <dl class="checkout-goods-list">
                    <dt class="clearfix">
                        <span class="col col-1">商品名称</span>
                        <span class="col col-2">购买价格(元)</span>
                        <span class="col col-3">购买数量</span>
                        <span class="col col-4">小计（元）</span>
                    </dt>
                    @foreach($data as $k=>$v)
                    <dd class="item clearfix">

                        <div class="item-row">
                            <div class="col col-1">
                                <div class="g-pic">
                                    <img src="{{URL::asset('/')}}{{$v->goodsImg}}" width="40" height="40" />
                                </div>
                                <div class="g-info">
                                    <a href="#" target="_blank" name="goodsName">
                                        {{$v->goodsName}}
                                    </a>
                                </div>
                            </div>

                            <div class="col col-2">{{$v->shopPrice}}</div>
                            <div class="col col-3">{{$v->goods_num}}</div>
                            <div class="col col-4" name="price">{{$v->shopPrice*$v->goods_num}}</div>
                        </div>

                    </dd>
                    @endforeach


                </dl>
                <div class="checkout-count clearfix">
                    <div class="checkout-count-extend xm-add-buy">
                        <h3 class="title">会员留言</h2></br>
                            <input type="text" />

                    </div>
                    <!-- checkout-count-extend -->
                    <div class="checkout-price">
                        <ul>

                            <li>
                                订单总额：<span id="sumMoney">{{$v->shopPrice*$v->goods_num}}</span>元
                            </li>
                            <!--<li>
                            活动优惠：<span>-0元</span>
                            <script type="text/javascript">
                            checkoutConfig.activityDiscountMoney=0;
                            checkoutConfig.totalPrice=244.00;
                            </script>
                            </li>-->
                            <!--<li>
                            优惠券抵扣：<span id="couponDesc">-0元</span>
                            </li>-->
                            <li>
                                运费：<span id="postageDesc">100</span>元
                            </li>
                        </ul>
                        <p class="checkout-total">应付总额：<span><strong id="totalPrice">{{$v->shopPrice*$v->goods_num}}</strong></span>元</p>
                    </div>
                    <!--  -->
                </div>
            </div>
        </div>

        <!--S 加价购 产品选择弹框 -->
        <div class="modal hide modal-choose-pro" id="J_choosePro-664" style>
            <div class="modal-header">
                <span class="close" data-dismiss='modal'><i class="iconfont">&#xe617;</i></span>
                <h3>选择产品</h3>
                <div class="more">
                    <div class="xm-recommend-page clearfix">
                        <a class="page-btn-prev   J_carouselPrev iconfont" href="javascript: void(0);">&#xe604;</a><a class="page-btn-next  J_carouselNext iconfont" href="javascript: void(0);">&#xe605;</a>
                    </div>
                </div>
            </div>
            <div class="modal-body J_chooseProCarousel">
                <div class="J_carouselWrap modal-choose-pro-list-wrap">
                    <ul class="clearfix J_carouselList">
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-disabled J_chooseProBtn">加入购物车</a>
            </div>
        </div>
        <!--E 加价购 产品选择弹框 -->

        <!--S 保障计划 产品选择弹框 -->


    </div>
    <!-- 商品清单 END -->
    <input type="hidden"  id="couponType" name="Checkout[couponsType]">
    <input type="hidden" id="couponValue" name="Checkout[couponsValue]">
    <div class="checkout-confirm">

        <a href="{{url('order/index')}}" class="btn btn-lineDakeLight btn-back-cart">取消</a>
        <input type="submit" value="立即下单" class="btn btn-primary"  id="downOrder"/>
        <!--<a href="#" class="btn btn-primary">立即下单</a>-->

    </div>
</div>
</div>

</form>

</div>
<!-- 禮品卡提示 S-->
<div class="modal hide lipin-modal" id="lipinTip">
<div class="modal-header">
<h2 class="title">温馨提示</h2>
<p> 为保障您的利益与安全，下单后礼品卡将会被使用，<br>
且订单信息将不可修改。请确认收货信息：</p>
</div>
<div class="modal-body">
<ul>
<li><strong>收&nbsp;&nbsp;货&nbsp;&nbsp;人：</strong><span id="lipin-uname"></span></li>
<li><strong>联系电话：</strong><span id="lipin-uphone"></span></li>
<li><strong>收货地址：</strong><span id="lipin-uaddr"></span></li>
</ul>
</div>
<div class="modal-footer">
<span class="btn btn-primary" id="useGiftCard">确认下单</span><span class="btn btn-dakeLight" id="closeGiftCard">返回修改</span>
</div>
</div>
<!--  禮品卡提示 E-->
<!-- 预售提示 S-->
<div class="modal hide yushou-modal" id="yushouTip">
<div class="modal-body">
<h2>请确认收货地址及发货时间</h2>
<ul class="list">
<li>
    <strong>请确认配送地址，提交后不可变更：</strong>
    <p id="yushouAddr"> </p>
    <span class="icon-common icon-1"></span>
</li>
<li>
    <strong>支付后发货</strong>
    <p>如您随预售商品一起购买的商品，将与预售商品一起发货</p>
    <span class="icon-common icon-2"></span>
</li>
<li>
    <strong>以支付价格为准</strong>
    <p>如预售产品发生调价，已支付订单价格将不受影响。</p>
    <span class="icon-common icon-3"></span>
</li>
</ul>
</div>
<div class="modal-footer">
<p id="yushouOk" class="yushou-ok">
<span class="icon-checkbox"><i class="iconfont">&#xe626;</i></span>
我已确认收货地址正确，不再变更</p>
<span class="btn btn-lineDakeLight" data-dismiss="modal">返回修改地址</span>
<span class="btn btn-primary" id="yushouCheckout">继续下单</span>

</div>
</div>
<!--  预售提示 E-->
<script>
//地址验证

//邮政编码验证
function mail()
{
var zipcode = $("#zipcode").val();

var reg = /^[0-9][0-9]{5}$/;
if (zipcode.value.length == 0)
{
layer.msg("邮政编码不能为空", {
time:2000,
icon:2

})
}

else if (reg.test(zipcode))
{
layer.msg("请输入正确的邮政编码", {
time:2000,
icon:2

})
}

}

//表单验证
function checkname()
{
var name = $("#Consignee").val();
var reg = /^[\u0391-\uFFE5]+$/; //只能输入中文
if (name.value.length == 0)
{
layer.msg("姓名不能为空", {
time:2000,
icon:2


})

}
if (reg.test(name.value) == false)
{
layer.msg("姓名必须为中文", {
time:2000,
icon:2


})
}


}

//手机号验证
function phone()
{

var Telephone = $("#Telephone").val();
var reg = /^(13[0-9]{9})| (18[0-9]{9}) |(15[89][0-9]{8})$/;
if (Telephone.value.length == 0)
{
layer.msg("手机号不能为空", {
time:2000,
icon:2


})
}

else if (Telephone.value.substring(0, 1) !== "1" || reg.test(Telephone.value) == false) {
layer.msg("请输入正确的手机号", {
time:2000,
icon:2


})
}

else if (Telephone.value.length > 11 || Telephone.value.length < 11) {
layer.msg("手机号为11位", {
time:2000,
icon:2

})
}

}

//点击取消按钮隐藏地址表单
function cancelAddres(){

$("#address").hide();
}


//点击加号显示隐藏地址表单
$("#checkoutAddrList").on("click", "#formdata", function(){

$("#address").toggle();
})

//三级联动点击省展示市的数据
$("#provinces").change(function(){
$("#city").empty();

var id = $(this).val();
$.ajax({
url:"{{url('order/city')}}",
data:{id:id},
success:function(res){
$("#city").append("<option value='请选择市'>请选择市</option>");
for (var i = 0; i < res.length; i++)
{
$("#city").append("<option value=" + res[i].id + ">" + res[i].areaName + "</option>");
}

}
})
})

//点击市改变区
$("#city").change(function(){
$("#distruct").empty();
var value = $(this).val();
$.ajax({
url:"{{url('order/distruct')}}",
data:{value:value},
success:function(res){
$("#distruct").append("<option value='请选择县'>请选择城县</option>");
for (var i = 0; i < res.length; i++)
{
$("#distruct").append("<option value=" + res[i].id + ">" + res[i].areaName + "</option>");
}

}

})
})


//判断是否选中
$("#zaixian").click(function(){
$("#zaixian").attr("class", "item selected");
$("#zaixian").attr("checked");
$("#huodao").attr("class", "");
$("huodao").removeAttr("checked");
})

$("#huodao").click(function(){
$("#huodao").attr("class", "item selected");
$("#huodao").attr("checked");
$("#zaixian").attr("class", "");
$("#zaixian").removeAttr("checked");
})

//送货时间
$("#time1").click(function(){
$("#time1").attr("class", "item selected");
$("#time2").attr("class", "");
$("#time3").attr("class", "");
})
$("#time2").click(function(){
$("#time2").attr("class", "item selected");
$("#time1").attr("class", "");
$("#time3").attr("class", "");
})
$("#time3").click(function(){
$("#time3").attr("class", "item selected");
$("#time2").attr("class", "");
$("#time1").attr("class", "");
})

//发票信息
$("#info1").click(function(){
$("#info1").attr("class", "item selected");
$("#info2").attr("class", "");
})
$("#info2").click(function(){
$("#info2").attr("class", "item selected");
$("#info1").attr("class", "");
})

//保存地址的添加
function baocun()
{
var name = $("#Consignee").val();
var telephone = $("#Telephone").val();
var provinces = $("#provinces").val();
var city = $("#city").val();
var distruct = $("#distruct").val();
var zipcode = $("#zipcode").val();
var tag = $("#tag").val();
var street = $("#street").val();
var user_id = $("#user_id").val();
var orderId = $("#orderId").val();
$.ajax({
headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
        url:"{{url('order/newAddress')}}",
        data:{user_name:name, tell:telephone, province:provinces, city:city, distruct:distruct, email:zipcode, addresstag:tag, street:street, user_id:user_id, order_id:orderId},
        type:'post',
        dataType:'json',
        success:function(data)
        {
       
        if (data.code === 1){
        var str = "<dl class='item' ><dt><strong class='itemConsignee'>收件人姓名：" + data.data.user_name + "</strong></dt><dd><p class='tel itemTel'>收件人电话：" + data.data.tell + "</p><p class='itemRegion'>收件人地址：" + data.data.provinceId + "" + data.data.cityId + "" + data.data.distructId + "</p><p class='itemStreet'>下单时间：</p><span class='edit-btn J_editAddr'>编辑</span></dd><dd style='display:none'><input type='radio' name='Checkout[address]' class='addressId'  value='10140916720030323'></dd></dl>";
        $("#item").after(str);
        history.go(0);
        }
        if(data.code===2)
        {
        alert("请点击管理地址");
        }
        
        }
})
}
                
                

//选择收货地址
function item(id)
        {

        $("dl.item").each(function(k, v){
        $(v).attr("style", "");
        })

                var item = $("#item" + id).attr("data-id");
        $("#item" + id).css("border-color", "red");
        $.ajax({
        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                url:"{{url('order/updateAddressId')}}",
                data:{address_id:item},
                type:'post',
                dataType:'json',
                success:function(data){
                    
                     
                     
                }
        })
                }

//如果展示地址超过三个则隐藏新添加地址
$(function(){
var count=$("dl.item").length;
if(count===3)
{
$("#formdata").hide();
}
//否则展示继续添加地址
else if(count<3)
{
$("#formdata").show();
}

//订单总价格

var sum=0;

$("div[name='price']").each(function(){
sum+=parseFloat($(this).text());

})
var price=$("#postageDesc").text();
$("#sumMoney").text(sum);
var yunfei=$("#postageDesc").text();
sum1=(sum-0)+(yunfei-0);

$("#totalPrice").text(sum1);

})


//立即下单

$("#downOrder").on("click", function(e){
e.preventDefault();
var orderNo = "{{$data[0]->orderNo}}";
var goodsName="";

$("a[name='goodsName']").each(function(){
  goodsName+=$(this).text();
});
var orderMoney=$("#totalPrice").text();
var orderRemarks="{{$data[0]->orderRemarks}}";
location.href="{{url('order/alipay')}}?orderNo="+orderNo+"&goodsName="+goodsName+"&orderMoney="+orderMoney+"&orderRemarks="+orderRemarks;
//                    var objects = $("dl.item");
//                    objects.each(function(k, v){
//                    if ($(v).attr("style").indexOf("border-color") >= 0)
//                    {
//                    //地址ID
//                    var address_id = $(v).attr("data-id");
//                    $.ajax({
//                         headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
//                         url:"{{url('order/address')}}",
//                         data:{address_id:address_id},
//                         type:"post",
//                         dataType:"json",
//                         success:function(data){
//                             if(data.code==1)
//                             {
//                                 console.log(data);
//                             }
//                               
//                         }
//                        
//                    })
//                    
//                    
//                    
//                    }
//                    });

})




</script>


@endsection







