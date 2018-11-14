<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\Cart;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use function PHPSTORM_META\type;
use App\Http\Models\Goods_cats;

class CartController extends Controller
{
    /**  用户购物车信息和展示
     * @author xiaowei.fan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart()
    {
        $userId = session()->get('userId');
        $userCarts = Cart::getUserCart($userId)->toArray();
        $count = 0;
        $isAllCheck = true;
        $checkNum = 0;
        $rCount = 0;
        $rCheckNum = 0;
        foreach ($userCarts as $k => $v) {
            $rCount += (intval($v['num'])) * floatval($v['shopPrice']);
            $rCheckNum += 1;
            if ($v['isCheck'] == 0) {
                $isAllCheck = false;
            }
            if ($v['isCheck'] == 1) {
                $count += (intval($v['num'])) * floatval($v['shopPrice']);
                $checkNum += 1;
            }
        }
        $catList = Goods_cats::getCatList();
        return view('home.cart.cart', [
            'userCarts' => $userCarts,
            'isAllCheck' => $isAllCheck,
            'count' => $count,
            'checkNum' => $checkNum,
            'rCount' => $rCount,
            'rCheckNum' => $rCheckNum,
            'catList'=>$catList
        ]);
    }

    /**
     * 购物车商品数量加减修改
     * @author xiaowei.fan
     * @return \Illuminate\Http\JsonResponse
     */
    public function cartNumC()
    {
        $num = Request::get('num');
        $cartId = Request::get('cartId');
        $updateRes = Cart::updNum($cartId, $num);
        if ($updateRes) {
            return response()->json([
                'code' => 1,
                'message' => '操作成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'message' => '操作失败'
            ]);
        }
    }

    /**
     * 购物车商品删除
     * @author xiaowei.fan
     * @return \Illuminate\Http\JsonResponse
     */
    public function cartDel()
    {
        $cartId = Request::get('cartId');
        $delRes = Cart::cartDel($cartId);
        if ($delRes) {
            return response()->json([
                'code' => 1,
                'message' => '删除成功'
            ]);
        } else {
            return response()->json([
                'code' => 0,
                'message' => '删除失败'
            ]);
        }
    }

    /**
     * 修改购物车商品的选择状态
     * @author xiaowei.fan
     * @return \Illuminate\Http\JsonResponse
     */
    public function cartCheck()
    {
        $isCheck = Request::get('isCheck');
        $cartId = Request::get('cartId');
        $updRes = Cart::updCheck($isCheck, $cartId);
        if ($updRes) {
            return response()->json([
                'code' => 1,
                'message' => '操作成功'
            ]);
        } else {
            return response()->json([
                'code' => 0,
                'message' => '操作失败'
            ]);
        }
    }

    public function joinCart()
    {
        $num = Request::get('num');
        $goodsId = Request::get('goodsId');
        $userId = session()->get('userId');
        $addTime = date('Y-m-d H:i:s');
        $isCheck = 1;
        $findRes = Cart::where([
            'num' => $num,
            'goodsId' => $goodsId,
            'userId' => $userId,
        ])->first();
        if ($findRes) {
            return response()->json([
                'code' => 2,
                'message' => '您已经添加此商品到购物车！'
            ]);
        } else {
            $addRes = Cart::insert([
                'num' => $num,
                'goodsId' => $goodsId,
                'userId' => $userId,
                'addTime' => $addTime,
                'isCheck' => $isCheck
            ]);
            if ($addRes) {
                $num = session()->get('cartNum');
                session()->put('cartNum', intval($num)+1);
                return response()->json([
                    'code' => 1,
                    'message' => '添加成功'
                ]);
            } else {
                return response()->json([
                    'code' => 2,
                    'message' => '添加失败'
                ]);
            }
        }
    }
}