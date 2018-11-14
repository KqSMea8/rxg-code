<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class Favorites extends Model
{
	public $timestamps=false;
	protected $table ='favorites';
	//添加关注
	public function addData($data)
	{
		return self::insert($data);
	}

	//查看用户关注的商品
	public function userFavoritesGoods($userId,$where='')
	{
		return self::where(['userId'=>$userId,'favoriteType'=>1],$where)->get()->toArray();
	}

	//查看用户关注的店铺
	public function userFavoritesShop($userId)
	{
		return self::where(['userId'=>$userId,'favoriteType'=>0])->get()->toArray();
	}

	public function delGoodsData($userId,$objectId)
	{
		return self::where(['userId'=>$userId,'favoriteType'=>1])->whereIn('objectId',$objectId)->delete();
	}

	public function delShopsData($userId,$objectId)
	{
		return self::where(['userId'=>$userId])->whereIn('objectId',$objectId)->delete();
	}
	
}