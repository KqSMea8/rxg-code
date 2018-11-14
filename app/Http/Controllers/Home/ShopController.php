<?php 
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Models\Goods;
use App\Http\Models\Shops;
use App\Http\Models\Goods_cats;
use App\Http\Models\Favorites;
use Illuminate\Support\Facades\Request;
class ShopController extends Controller
{
	/**
	 * 推荐商品列表
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.5
	 * @return [array] [$data]
	 */
	public function goods()
	{
		$goods = new Goods;
		$data = $goods->getPage();
		$catList = Goods_cats::getCatList();
		return view('home.shop.goods',['data'=>$data,'catList'=>$catList]);
	}


	/**
	 * 店铺中心列表
	 * @author xiaqingquan <944609796@qq.com>
	 * @return [array] [$data]
	 */
	public function shops()
	{
		$shop = new Shops;
		$data = $shop->getData();
		$catList = Goods_cats::getCatList();
		return view('home.shop.shop',['data'=>$data,'catList'=>$catList]);
	}

	/**
	 * 店铺详情
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.5
	 * @return [array] [$data]
	 */
	public function shopShow()
	{
		$id = Request::get('id');
		$shop = new Shops;
		$data = $shop->getOne($id);
		$catList = Goods_cats::getCatList();
		return view('home.shop.shopShow',['data'=>$data,'catList'=>$catList]);
	}

	/**
	 * 执行添加商品关注
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.5
	 * @return [bool] [$res]
	 */
	public function addGoodsFavorites()
	{
		$data['objectId'] = Request::get('id');
		$data['favoriteType'] = 1;
		$data['userId'] = session()->get('userId');
		$data['addTime'] = date('Y-m-d H:i:s');
		$favorites = new Favorites;
		$res = $favorites->addData($data);
		if ($res) {
			return redirect('shop/goods');
		}else{
			return redirect('shop/goods');
		}
	}

	/**
	 * 执行添加店铺关注
	 * @author xiaqingquan <944609796@qq.com>
	 * @version laravel5.5
	 * @return [bool] [$res]
	 */
	public function addShopFavorites()
	{
		$data['objectId'] = Request::get('id');
		$data['favoriteType'] = 0;
		$data['userId'] = session()->get('userId');
		$data['addTime'] = date('Y-m-d H:i:s');
		$favorites = new Favorites;
		$res = $favorites->addData($data);
		if ($res) {
			return redirect('shop/shops');
		}else{
			return redirect('shop/shops');
		}
	}



}