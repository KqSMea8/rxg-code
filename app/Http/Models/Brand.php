<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brand extends Model
{
	protected $table='brand';
	


        public function brandOne($where=[])
        {
            $data=$this->where($where)->first();
            return $data;
            
        }
	//按id查询一条品牌数据
	public function getOne($bid)
		{
			return self::where(['brandId'=>$bid])->first();
		}
//获取所有品牌数据
	public function getBrand($uname='')
	{
		$data = $this->leftJoin('goods_cats','goods_cats.catId','brand.catId')
					->select('brand.*','goods_cats.catId','goods_cats.catName')
					->where("brandName","like","%$uname%")
					->paginate(10);
		return $data;
	}
	//获取所有品牌数据
	public function getData()
	{
		return self::all()->toArray();
	}

	public function getDatas($where=[]){
        $data = $this->leftjoin('goods_cats','goods_cats.catId','brand.catId')
            ->select('brand.*','goods_cats.catId','goods_cats.catName')
            ->where($where)
            ->get();
        return $data;
    }
//修改查询
	public function sele($table)
	{
		return DB::select("select * from $table");
	}
	public function up($id)
	{
		$data = $this->leftjoin('goods_cats','goods_cats.catId','brand.catId')
					->select("brand.brandId","brand.brandName","brand.brandImg","brand.brandDesc","brand.status","goods_cats.catId")
					->where(['brandId'=>$id])
					->first();
		return $data;
	}
    //添加品牌
    public function addData($data)
    {
        return self::insert($data);
    }
    //删除
    public static function delData($where){
        return self::where($where)->delete();
    }

}