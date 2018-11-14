<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class Shops extends Model
{
	protected $table='shops';

	//查询有所店铺每页4条数据
	public function getData()
	{
		return self::paginate(4);
	}

	//根据id查询一条店铺数据
	public function getOne($id)
		{
			return self::where(['shopId'=>$id])->first()->toArray();
		}

	//按多个id查询店铺数据
	public function getMoreShops($ids)
		{
			return self::whereIn('shopId',$ids)->paginate(2);
		}

}