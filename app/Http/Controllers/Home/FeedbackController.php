<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\FeedBack;
use Request;
use App\Http\Models\Goods_cats;

class FeedbackController extends Controller
{
    public function feedback()
    {
        $userId = session()->get('userId');
        $catList = Goods_cats::getCatList();
        return view('home.feedback.feedback', [
            'userId' => $userId,
            'catList'=>$catList
        ]);
    }

    public function addFeedback()
    {
        $feedback = new FeedBack();
        $data['member_id'] = Request::post('userId');
        $data['content'] = Request::post('content');

        $result = $feedback->where(['member_id' => $data['member_id'], 'content' => $data['content']])->first();
        if ($data['content'] == $result['content']) {
            return response()->json([
                'code' => 0,
                'msg' => '请勿添加重复内容'
            ]);
        }
        $data['status'] = 1;
        $data['member_unread'] = 0;
        $data['sys_unread'] = 1;
        $data['created_time'] = date('Y-m-d H:i:s', time());
        $res = $feedback->insert($data);
        if ($res) {
            return response()->json([
                'code' => 1,
                'msg' => '添加成功'
            ]);
        } else {
            return response()->json([
                'code' => 0,
                'msg' => '添加失败'
            ]);
        }
    }
}