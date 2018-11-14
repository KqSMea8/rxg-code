@extends('merchant.layout.default')
@section('content')
    <div class="container" style="width: 100%;">
        <div class="row mt">
            <!--CUSTOM CHART START -->
            <div class="border-head">
                <h3>销量排行榜</h3>
            </div>
            <div class="custom-bar-chart">
                <ul class="y-axis">
                    <li><span>10000</span></li>
                    <li><span>8000</span></li>
                    <li><span>6000</span></li>
                    <li><span>4000</span></li>
                    <li><span>2000</span></li>
                    <li><span>0</span></li>
                </ul>
                @foreach($data as $key => $val)
                    <div class="bar">
                        <div class="title">{{$val->goodsName}}</div>
                        <div class="value tooltips" data-original-title="{{$val->saleNum}}" data-toggle="tooltip" data-placement="top">{{$val->saleNum/10000*100}}%</div>
                    </div>
                @endforeach
            </div>
            <!--custom chart end-->
        </div><!-- /row -->


        <div class="col-md-4 col-sm-4 mb" style="margin-top: 35px;">
            <!-- REVENUE PANEL -->
            <div class="darkblue-panel pn">
                <div class="darkblue-header">
                    <h5>总营业额</h5>
                </div>
                <div class="chart mt">
                    <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%"
                         data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color=""
                         data-highlight-line-color="#fff" data-spot-radius="4"
                         data-data="[200,135,667,333,526,996,564,123,890,464,655]"></div>
                </div>
                <p class="mt"><b>￥ {{$money}}</b><br/>{{session()->get('shopInfo')->shopName}}</p>
            </div>
        </div><!-- /col-md-4 -->

    </div>


@endsection