@extends('home.left.left')
@section('left')
<div class="member-right fr">
<div class="member-head">
    <div class="member-heels fl"><h2 style="margin-top: 2px"><a href="{{url('order/index')}}"><<<</a>商品详情信息</h2></div>
</div>

<div class="member-border">
<div class="member-return H-over">
<div class="member-sheet clearfix">
<ul>
    @foreach($data as $k=>$v)
<li>
<div class="member-circle clearfix">
<div class="ci1">
<div class="ci7 clearfix">
<a href="#"><img src="{{URL::asset('/')}}{{$v->goodsImg}}" title="" about="" width="370px" height="230px"></a>
<span class="gr2"></span>
<span class="gr3">
</span>
</div>

</div>
    <div>
        <div>
        <p>商品名称:{{$v->goodsName}}</p>
        <p>商品价格:{{$v->shopPrice}}</p>
        <p>剩余库存:{{$v->goodsStock}}</p>
        <p>总销售量:{{$v->saleNum}}</p>
        <p>上架时间:{{$v->saleTime}}</p>
        <p>商品描述:{{$v->goodsDesc}}</p>
        <p>共有{{$v->appraiseNum}}发表评论:</p>
        </div>
        <div style="float:right;margin-top: -153px;margin-right: 50px">
            
        </div>
    </div>
    
    
    
    
</li>
@endforeach

</ul>
</div>
</div>


<div class="clearfix" style="padding:30px 20px;">
<div  style="float: right">
</div>
</div>
</div>
</div>

@endsection

