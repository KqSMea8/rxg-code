<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Activity extends Model
{
    public $timestamps = false;
    protected $table = 'activity';
    //查询商品的信息
    public function goodsSelect()
    {
        return DB::select ("select  goodsId,goodsName,catId  from  rxg_goods");
    }
    //查询分类的信息
    public function catSelect()
    {
        return DB::select("select catId,catName from rxg_goods_cats where parentId = 0");
    }
    public function getOne($id)
    {
        return self::where(['id'=>$id])->first()->toArray();
    }
    //修改
    public function upd($id,$data)
    {
        return self::where(['id'=>$id])->update($data);
    }
    //删除
    public static function activityDel($where){
        return self::where($where)->delete();
    }
    public function selects($where)
    {
        $data=$this->join("goods","goods.goodsId","activity.goodsId")
                            ->join("goods_cats","goods_cats.catId","goods.catId")   
                            ->where($where)
                            ->paginate(10);
                            // echo "<pre>";
                            return $data;
    }
    // /添加
    public function insertData($data)
    {
        // print_r($data);die;
       return self::insert($data);
    }

    
}