@extends('merchant.layout.default')
@section('content')
    <style>
        .table tbody tr td {
            vertical-align: middle;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">商品评论</a></li>
        <li class="active">评论列表</li>
    </ol>
    <div class="container" style="width: 100%;">
            <table class="table-hover table table-bordered">
                <thead>
                <tr class="active">
                    <th>编号</th>
                    <th>用户昵称</th>
                    <th>商品名称</th>
                    <th>评论内容</th>
                    <th>状态</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->username}}</td>
                        <td>{{$v->goodsname}}</td>
                        <td>{{$v->content}}</td>
                        <td>
                            @if($v->shop_unread == 1)
                                已读
                            @elseif($v->shop_unread == 2)
                                已回复
                            @else
                                未读
                            @endif
                        </td>
                        <td>{{$v->created_time}}</td>
                        <td class="center">
                            <a href="{{url('merchant/comment/commentDetail')}}?id={{$v->id}}" title="查看详情"
                               class="btn btn-primary btn-xs">查看详情</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        <div style="float: right">
            {{$data->links()}}
        </div>
        </div>

@endsection