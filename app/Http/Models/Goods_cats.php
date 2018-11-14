<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Goods_cats extends Model
{
	public $timestamps=false;
	protected $table='goods_cats';
	//查询不在回收站的所有分类
	public function getData()
	{
		return self::where(['isHui'=>1])->orderBy('path')->orderBy('parentId')->paginate(10);
	}


	//父级分类分页
	public function getPage()
	{
		return self::where(['parentId'=>0])->paginate(2);
	}

	//查询多有父级分类
	public function getParent()
	{
		return self::where(['parentId'=>0,'isHui'=>1])->get();
	}
	//添加分类
	public function addData($data)
	{
		return self::insertGetId($data);
	}
	//获取最后一条插入数据的id
	public function addGetId($data)
	{
		return self::insertGetId($data);
	}
	//按分类名称查询一条数据
	public function checkName($catName)
	{
		return self::where(['catName'=>$catName])->first();
	}
	//删除分类
	public function delData($id)
	{
		return self::where(['catId'=>$id])->delete();
	}
	//删除子分类
	public function delSon($id)
	{
		return self::whereIn('parentId',$id)->delete();
	}
	//批量删除分类
	public function delPi($ids)
	{
		return self::whereIn('catId',$ids)->delete();
	}

	//传入多个父id获取子级id
	public function getSon($ids)
	{
		return self::whereIn('parentId',$ids)->get()->pluck('catId');
	}

	//根据父级id查询获取一条子级id
	public function getOneSon($id)
	{
		return self::where(['parentId'=>$id])->get()->pluck('catId');
	}

	//传入一个父id获取多个子级id
	public function getSons($id)
	{
		return self::where(['parentId'=>$id])->get();
	}


	//修改放入回收站
	public function updateHuiFu($id,$data)
	{
		return self::where(['catId'=>$id])->update($data);
	}
	//按着多个id查询分类
	public function piHui($ids)
	{
		return self::whereIn('catId',$ids)->get()->toArray();
	}

	//根据id查询一条分类
	public function getOne($id)
	{
		return self::where(['catId'=>$id])->first()->toArray();
	}

	//查询回收站分类分页
	public function getHuiData()
	{
		return self::where(['isHui'=>0])->paginate(2);
	}

	//批量放入回收站
	public function updatePiHui()
	{
		return self::where(['catId'=>$id])->update($data);
	}

    /**
     * 获取前台分类
     * @author xiaowei.fan
     * @param bool $isGet
     * @return mixed
     */
    public static function getCatList($isGet = false){
        if(empty(Redis::get('catList')) || $isGet) {
            $catList = Goods_cats::where('parentId',0)->get()->toArray();
            foreach ($catList as $k=>$v) {
                $catList[$k]['child'] = Goods_cats::where('parentId',$v['catId'])->get()->toArray();
                foreach ($catList[$k]['child'] as $key=>$val) {
                    $catList[$k]['child'][$key]['child'] = Goods_cats::where('parentId',$val['catId'])->get()->toArray();
                }
            }
            Redis::set('catList',serialize($catList));
        }else{
            $catList = unserialize(Redis::get('catList'));
        }
        return $catList;
    }
}