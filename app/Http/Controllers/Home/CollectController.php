<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Models\Favorites;
use App\Http\Models\Goods;
use App\Http\Models\Shops;
use Illuminate\Support\Facades\Request;
use App\Http\Models\Goods_cats;
class CollectController extends Controller
{
	/**
	 *关注的商品列表
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.5
	 * @return [array] [$data]
	 */
	public function favoriteGoods()
	{
		$goodsName = Request::get('goodsName');
		//登录出来后，改为session里的用户id
		$userId = session()->get('userId');
		$favorites = new Favorites;
		$res = $favorites->userFavoritesGoods($userId);
		$goodsId = [];
		foreach ($res as $key => $v) {
			array_push($goodsId,$v['objectId']);
		}
		$goods = new Goods;
		$data = $goods->getMoreGoods($goodsId,$goodsName);
		if (Request::AJAX()) {
			return json_encode($data);
		}else{
            $catList = Goods_cats::getCatList();
		    return view('home.collect.favoriteGoods',[
		        'data'=>$data,
                'catList'=>$catList
            ]);
		}
	}

	/**
	 * 关注的店铺列表
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.5
	 * @return [array] [$data]
	 */
	public function favoriteShop()
	{
		//登录出来后，改为session里的用户id
        $userId = session()->get('userId');
		$favorites = new Favorites;
		$res = $favorites->userFavoritesShop($userId);
		$shopsId = [];
		foreach ($res as $key => $v) {
			array_push($shopsId,$v['objectId']);
		}
		$shops = new Shops;
		$data = $shops->getMoreShops($shopsId);
		foreach ($data as $key => $value) {
			$data[$key]->goodsList = Goods::where('shopId',$value->shopId)->get()->toArray();
		}
        $catList = Goods_cats::getCatList();
		return view('home.collect.favoriteShop',[
		    'data'=>$data,
            'catList'=>$catList
        ]);
	}
	
	/**
	 * 删除我关注的商品
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.5 
	 * @return [array] [$arr]
	 */
	public function delFavoriteGoods()
	{
        $userId = session()->get('userId');
		$objectId = Request::get('ids');
		$favorites = new Favorites;
		$res = $favorites->delGoodsData($userId,$objectId);
		if ($res) {
			$arr = [
				'code'=>1,
				'message'=>'删除成功',
				'data'=>$res,
			];
		}else{
			$arr = [
				'code'=>0,
				'message'=>'删除失败',
				'data'=>'',
			];
		}
		return json_encode($arr);
	}

	//
	/**
	 * 删除我关注的商家
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.55
	 * @return [array] [$arr]
	 */
	public function delFavoriteShops()
	{
        $userId = session()->get('userId');
		$objectId = Request::get('ids');
		$favorites = new Favorites;
		$res = $favorites->delShopsData($userId,$objectId);
		if ($res) {
			$arr = [
				'code'=>1,
				'message'=>'删除成功',
				'data'=>$res,
			];
		}else{
			$arr = [
				'code'=>0,
				'message'=>'删除失败',
				'data'=>'',
			];
		}
		return json_encode($arr);
	}


	
    public function addFavorite(){
        $userId = session()->get('userId');
        $goodsId = Request::get('goodsId');
        $findRes = Favorites::where([
            'userId'=>$userId,
            'favoriteType'=>1,
            'objectId'=>$goodsId,
        ])->first();
        if($findRes){
            $delRes = Favorites::where([
                'userId'=>$userId,
                'favoriteType'=>1,
                'objectId'=>$goodsId,
            ])->delete();
            if ($delRes){
                return response()->json([
                    'code'=>1,
                    'message'=>'取消收藏成功',
                    'data'=>'收藏此商品'
                ]);
            }else{
                return response()->json([
                    'code'=>2,
                    'message'=>'取消收藏失败'
                ]);
            }
        }else{
            $addRes = Favorites::insert([
                'userId'=>$userId,
                'favoriteType'=>1,
                'objectId'=>$goodsId,
                'addTime'=>date('Y-m-d H:i:s')
            ]);
            if ($addRes){
                return response()->json([
                    'code'=>1,
                    'message'=>'收藏成功',
                    'data'=>'取消收藏'
                ]);
            }else{
                return response()->json([
                    'code'=>2,
                    'message'=>'收藏失败'
                ]);
            }
        }
    }
}

