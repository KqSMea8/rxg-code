<?php
/**
 * 商品评论控制器
 *
 * @author story_line
 */
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Models\Comment;
use App\Http\Models\CommentReply;
use App\Http\Models\Goods;
use App\Http\Models\RxgUser;
use Illuminate\Support\Facades\Request;

class CommentController extends Controller
{
    /**
     * 商品评论列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function comment()
    {
        $comment = new Comment();
        $goods = new Goods();
        $user = new RxgUser();
        $data = $comment->paginate(10);
        foreach ($data as $key => $value) {
            $data[$key]['goodsname'] = $goods->where(['goodsId' => $value['goods_id']])->value('goodsName');
            $data[$key]['username'] = $user->where(['userId' => $value['member_id']])->value('username');
        }
        return view('merchant.comment.comment_list', ['data' => $data]);
    }

    /**
     * 商品评论详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function commentDetail()
    {
        $id = Request::get('id');
        $comment = new Comment();
        $commentReply = new CommentReply();
        $comment->where(['id' => $id])->update(['shop_unread' => 1]);
        $commentReplyList = $commentReply->where(['comment_id' => $id])->get();

        return view('merchant.comment.comment_detail', [
            'data' => $commentReplyList,
            'comment_id' => $id
        ]);
    }

    /**
     * 商品评论回复
     * @return \Illuminate\Http\JsonResponse
     */
    public function commentReplyAdd()
    {
        $commentId = Request::post('comment_id');
        $content = Request::post('content');
        $comment = new Comment();
        $commentReply = new CommentReply();
        $res = $commentReply->where(['content' => $content])->get()->toArray();
        if ($res) {
            return response()->json(['code' => 0, 'msg' => '回复重复']);
        }
        if (empty($commentId) || empty($content)) {
            return response()->json(['code' => 0, 'msg' => '参数错误']);
        } else {
            $data['comment_id'] = $commentId;
            $data['content'] = $content;
            $data['type'] = 2;
            $data['status'] = 1;
            $data['shop_id'] = session()->get('shopId');
            $data['created_time'] = date("Y-m-d H:i:s");
            $commentReply->insert($data);
            $comment->where(['id' => $commentId])->update(['member_unread' => 1]);
            $comment->where(['id' => $commentId])->update(['shop_unread' => 2]);
            return response()->json([
                'code' => 1,
                'created_time' => $data['created_time'],
                'content' => $data['content']
            ]);
        }
    }
}