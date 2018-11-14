<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/24
 * Time: 19:38
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Http\Models\Area;

use App\Http\Models\Favorites;

use App\Http\Models\Gallery;

use App\Http\Models\Goods;

use App\Http\Models\User;

use App\Http\Models\Orders;

use App\Http\Models\Shops;

use App\Http\Models\MoneyBack;

use App\Http\Models\GoodsAppraises;

use App\Http\Models\GoodsComment;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\URL;

use App\Http\Models\Goods_cats;

use App\Http\Models\Attributes;

use App\Http\Models\AttributesValue;

use App\Http\Models\GoodsSku;
class GoodsController extends Controller
{
    public function detail(){
        $goodsId = Request::get('goodsId');
        //用户登录的id
        $userId = session()->get('userId');
        // Cookie::queue('userhistory'.$userId,$goodsId,60);
        $userHistory = Cookie::get('userhistory'.$userId);
        Cookie::queue('userhistory'.$userId,$goodsId.','.$userHistory,60*60*24*30);

        // Redis::RPUSH('history:'.$userId,$goodsId);
        // Redis::EXPIRE('history'.$userId,60*60*24*30);
        $shopId = Request::get('shopId');
        $orders = new Orders;
        $moneyBack = $orders->getMoneyBackData($shopId);
        if (!empty($moneyBack)) {
            $payMoney = $moneyBack['realTotalMoney'];
            $data['money'] = ($payMoney*0.05);
            $data['shopId'] = $shopId;
            $data['addTime'] = date('Y-m-d H:i:s');
            $moneyBack = new MoneyBack;
            $moneyBack->addData($data);
        }
        $username = User::where(['userId'=>$userId])->first();
        $goodsInfo = Goods::leftJoin('shops','goods.shopId','shops.shopId')->where('goodsId',$goodsId)->first();
        $goodsThumb = Gallery::where('goodsId',$goodsId)->get();
        $isCollect = Favorites::where(['objectId'=>$goodsId,'userId'=>$userId])->first();
        $province = Area::where('parentId',1)->get();
        $goodsComment = GoodsComment::where('goods_id',$goodsId)->get();
        $hotGoodsList = $this->getHotGoods();
        $goodsAppraises = GoodsAppraises::where(['goodsId'=>$goodsId,'userId'=>$userId])->get();
        $shopArr = Shops::where(['userId'=>$userId])->first();
        $shopId = $shopArr ? $shopArr->shopId : '';
        $url = URL::current().'?goodsId='.$goodsId.'&shopId='.$shopId;
        $catList = Goods_cats::getCatList();
        $catId=$goodsInfo->catId;
        $attributes=Attributes::getAttr($catId,1);
         foreach ($attributes as $k=>$v) {
            $attributes[$k]['attrValue'] = AttributesValue::getAttrValue($v->attrId);
        }
        

        Redis::hset("guess:user:love",$_SERVER['REMOTE_ADDR'],$goodsInfo->catId);
        return view('home.goods.detail',[
            'goodsInfo'=>$goodsInfo,
            'goodsThumb'=>$goodsThumb,
            'isCollect'=>($isCollect)?1:0,
            'province'=>$province,
            'goodsComment'=>$goodsComment,
            'hotGoodsList'=>$hotGoodsList,
            'goodsAppraises'=>$goodsAppraises,
            'username'=>$username,
            'url' => $url,
            'catList'=>$catList,
            "attributes"=>$attributes
        ]);
    }
    //点击不同的搭配展示不同的价格
    public function skuPrice()
    {
        $attr_values=Request::get("str");
        $model=new GoodsSku();
        $data=$model->goodsSkuOne($attr_values);
        if($data)
        {
            return response()->json([
                "code"=>1,
                "message"=>"替换成功",
                "data"=>$data
                
            ]);
        }
        else
        {
            return response()->json([
                "code"=>2,
                "message"=>"替换失败"
                
            ]);
        }
        
        
    }


    /**
     * 获取热销商品
     * @author xiaowei.fan
     * @return array
     */
    public function getHotGoods()
    {
        $data = Goods::getGoods();
        return $data['hotGoodsList'];
    }


    public function userHistory()
    {
        $userId = session()->get('userId');
        $str = Cookie::get('userhistory'.$userId);
        $userHistory = array_unique(explode(',',$str));
        $data = Goods::whereIn("goodsId",$userHistory)->paginate(6);
        $catList = Goods_cats::getCatList();
        // $history = Redis::LRANGE('history:'.$userId,0,-1);
        // $userHistory = array_unique($history);
        return view('home.goods.userhistory',['data'=>$data,'catList'=>$catList]);
    }


    public function delHistory()
    {

        $userId = session()->get('userId');
        $goodsId = Request::get('ids');
        Redis::lrem('history:'.$userId,0,$goodsId);
        $history = Redis::LRANGE('history:'.$userId,0,-1);
        
    }

    public function goodsList()
    {
        $goods  = new Goods;
        $goods_cats = new Goods_cats;
        $catId = Request::get('catId','');
        $goodsList = [];
        $titleTips = '';
        $esKeyword = '';
        if(!empty($catId)){
            $catIdList = $this->getCat([$catId],$goods_cats);
            $catName = $goods_cats->getOne($catId)['catName'];
            $titleTips = $catName.'分类下的商品：';
            if(!empty($catIdList)){
                $catId = array_merge([intval($catId)],$catIdList);
            }else{
                $catId = [$catId];
            }
            $data = $goods->getGoodsListByCatArr($catId);
            $goodsList = $data->toArray()['data'];
            $data->appends('catId',Request::get('catId'));
            $pagination = $data->links();
        }else{
            $esKeyword = Request::get('esKeyword','');
            $searchStr = '';
            for ($i=0;$i<mb_strlen($esKeyword);$i++){
                $searchStr.=' '.mb_substr($esKeyword,$i,1);
            }
            $data = Goods::search(ltrim($searchStr))->paginate(30);
            $goodsList = $data->toArray()['data'];
            $data->appends('esKeyword',Request::get('esKeyword'));
            $pagination = $data->links();
            $titleTips = '"'.$esKeyword.'"'.'的搜索结果';
        }
        $goodsList = array_chunk($goodsList,6);
        $catList = Goods_cats::getCatList();
        return view('home.goods.goodslist',[
            'data'=>$goodsList,
            'catList'=>$catList,
            'titleTips'=>$titleTips,
            'pagination'=>$pagination,
            'esKeyword'=>$esKeyword
        ]);
    }

    public function getCat($catId,$goods_cats){
        $catId = $goods_cats->getSon($catId)->toArray();
        if(!empty($catId)){
            $childId = $this->getCat($catId,$goods_cats);
            if(!empty($childId)){
                return array_merge($catId,$childId);
            }
        }
        return $catId;
    }
}