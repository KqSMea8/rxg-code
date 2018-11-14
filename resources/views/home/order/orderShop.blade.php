@extends('home.left.left')
@section('left')
<div class="member-right fr">
<div class="member-head">
    <div class="member-heels fl"><h2 style="margin-top: 2px"><a href="{{url('order/index')}}"><font color="white"><<<返回</font></a></h2></div>
<form action="{{url('order/index')}}">
<div class="member-backs member-icons fr"><button class="btn " style="margin-top: -15px;background:none;color: black">搜索</button></div>
<div class="member-about fr"><input placeholder="商品名称" type="text" name="keywords" ></div>
</form>
</div>
    <div>
        @foreach($data as $k=>$v)
        <dl>
            <dt><img src="{{URL::asset("$v->goodsImg")}}" width="250px"/></dt>
            <dd style="float: left;margin-left: 260px;margin-top: -140px">商品名称：{{$v->goodsName}}
                <p>商品价格:{{$v->shopPrice}}</p>
                <p>剩余库存:{{$v->goodsStock}}</p>
                <p>总销量:{{$v->saleNum}}</p>
                <p>商品描述:{{$v->goodsDesc}}</p>
                <p>浏览量:{{$v->visitNum}}</p>
                <p>共有{{$v->appraiseNum}}人发表评论</p>
                <p><font color="red">@if($v->isRecom==1) 本店强烈推荐@endif</font></p>

            </dd>
        </dl>
        <br>
       @endforeach
       
    </div>
    
    

</div>


@endsection

