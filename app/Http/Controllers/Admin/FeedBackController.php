<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\FeedBack;
use App\Http\Models\FeedBackReply;
use App\Http\Models\RxgUser;
use Illuminate\Support\Facades\Request;

class FeedBackController extends Controller
{
    public function feedBack()
    {
        $feedback = new FeedBack();
        $user = new RxgUser();
        $feedback_list = $feedback->paginate(10);
        foreach ($feedback_list as $key => $value) {
            $feedback_list[$key]['username'] = $user->where(['userId' => $value['member_id']])->select('username')->first()->toArray();
        }
        foreach ($feedback_list as $key => $value) {
            foreach ($value['username'] as $item => $val) {
                $value['username'] = $val;
            }
        }
        return view('admin.feedback.feedback_list', ['feedback_list' => $feedback_list]);
    }

    public function feedbackDetail()
    {
        $id = Request::get('id');
        $feedback = new Feedback();
        $feedback_reply = new FeedBackReply();
        $feedback->where(['id' => $id])->update(['sys_unread' => 1]);
        $feedback_reply_list = $feedback_reply->where(['feedback_id' => $id])->get();
        return view('admin.feedback.feedback_reply_detail', ['feedback_reply_list' => $feedback_reply_list, 'feedback_id' => $id]);
    }

    public function feedbackReplyAdd()
    {
        $id = Request::post('feedback_id');
        $content = Request::post('content');
        $feedback = new Feedback();
        $feedback_reply = new FeedbackReply();
        $res = $feedback_reply->where(['content' => $content, 'feedback_id' => $id])->get()->toArray();
        if ($res) {
            return response()->json(['code' => 0, 'msg' => '回复重复']);
        }
        if (empty($id) || empty($content)) {
            return response()->json(['code' => 0, 'msg' => '参数错误']);
        } else {
            $data['feedback_id'] = $id;
            $data['content'] = $content;
            $data['type'] = 2;
            $data['status'] = 1;
            $data['p_id'] = session()->get('adminId');
            $data['created_time'] = date("Y-m-d H:i:s");
            $feedback_reply->insert($data);
            $feedback->where(['id' => $id])->update(['member_unread' => 1]);
            $feedback->where(['id' => $id])->update(['sys_unread' => 2]);
            $msg = "<div class='list_div'>
                             <p>【{$data['created_time']}&nbsp;系统：】&nbsp;{$data['content']}</p >
                    </div>";
            return response()->json(['code' => 1, 'msg' => $msg]);
        }
    }
}