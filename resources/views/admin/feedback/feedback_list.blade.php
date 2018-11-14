@extends('admin.layout.default')
@section('content')
    <style>
        .table tbody tr td {
            vertical-align: middle;
        }
    </style>
    <ol class="breadcrumb" style="margin-top: 10px;">
        <li><a href="#">意见反馈</a></li>
        <li class="active">意见反馈列表</li>
    </ol>
    <div class="container" style="width:100%">
        <table class="table-hover table table-bordered">
            <thead>
            <tr class="active">
                <th>编号</th>
                <th>用户昵称</th>
                <th>意见内容</th>
                <th>状态</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($feedback_list as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->username}}</td>
                    <td>{{$v->content}}</td>
                    <td>
                        @if($v->sys_unread == 1)
                            已读
                        @elseif($v->sys_unread == 2)
                            已回复
                        @else
                            未读
                        @endif
                    </td>
                    <td>{{$v->created_time}}</td>
                    <td class="center">
                        <a href="{{url('admin/feedback/feedbackDetail')}}?id={{$v->id}}" title="查看详情"
                           class="btn btn-primary btn-xs">查看详情</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right">
        {{$feedback_list->links()}}
    </div>
    </div>
    
    </div>
@endsection