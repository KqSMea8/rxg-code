<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Http\Models\Activity;
use App\Http\Models\Advertising;
use App\Http\Models\Cart;
use App\Http\Models\Goods;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use App\Http\Models\Goods_cats;

class IndexController extends Controller
{
    /**
     * 前台首页
     * @author xiaowei.fan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $province = '北京';
        $model = new Advertising();
        $res = $model->find('rxg_province', "`province`='$province'");
        $arr = $res[0]->id;
        $sql = $model->find('rxg_advertising', "`province`=$arr");
        $time = date("Y-m-d H:i:s");
        $sql[0]->time = $time;
        //获取活动商品
        $goodsList = Goods::getGoods();
        $catList = Goods_cats::getCatList();
        $userIp = $_SERVER["REMOTE_ADDR"];
        $date = date('Y-m-d');
        //添加ip记录，时间做键
        Redis::PFADD($date,$userIp);
        if ($userId = session()->get('userId')) {
            $cartNum = Cart::getNum($userId);
            session()->put('cartNum', $cartNum);
        }
        $userCatId = Redis::hget('guess:user:love',$_SERVER['REMOTE_ADDR']);
        $guessUserLoveGoods = [];
        if(!empty($userCatId)){
            $guessUserLoveGoods = Goods::getUserLove(24,$userCatId);
        }
        return view("home.index.index", [
            'data' => $sql,
            'activeGoodsList' => $goodsList['activeGoodsList'],
            'hotGoodsList' => $goodsList['hotGoodsList'],
            'recomGoodsList' => $goodsList['recomGoodsList'],
            'catList' => $catList,
            'userLove'=>$guessUserLoveGoods
        ]);
    }


    //联系我们
    public function About()
    {
        return view('home.layout.About');
    }


    //关于我们
    public function Abouts()
    {
        return view('home.layout.Abouts');
    }


    //诚聘英才
    public function Careers()
    {
        return view('home.layout.Careers');
    }


    // 用户服务协议
    public function service()
    {
        return view('home/layout/service');
    }


    // 网站服务条款
    public function sites()
    {
        return view('home/layout/sites');
    }
    
}