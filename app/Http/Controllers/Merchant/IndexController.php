<?php
/**
 * 店铺信息控制器
 *
 * @author story_line
 */
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Models\Goods;
use App\Http\Models\Orders;
use App\Http\Models\ShopGoods;

class IndexController extends Controller
{
    /**
     * 店铺信息预览
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index()
    {
        $goods = new Goods();
        $shop_goods = new ShopGoods();
        $goods_id = $shop_goods->where('shop_id', session()->get('shopId'))->value('goods_id');
        $goods_id = explode(',', $goods_id);
        $data = $goods->whereIn('goodsId', $goods_id)->orderBy('saleNum','desc')->paginate(7);
        $order = new Orders();
        $money = $order->where('shopId', session()->get('shopId'))->sum('totalMoney');
        return view('merchant.index.index',[
            'data' => $data,
            'money' => $money
        ]);
    }
}