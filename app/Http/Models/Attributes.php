<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class Attributes extends Model
{
    protected $table='attributes';
    public $timestamps = false;
    public static function getAttr($catId,$attrType)
    {
       $data=self::where([   
           ["goodsCatId",$catId],
           ['attrType',$attrType],
           ["status",1],
           ["isShow",1]
           ])->get();
       return $data;
    }
    public static function getSpec($attrType)
    {
        $data=self::where([
            ['attrType',$attrType],
            ["status",1],
            ["isShow",1]
        ])->get()->toArray();
        return $data;
    }
    public static function getAttrList($attrName=''){
        return self::leftJoin('goods_cats','attributes.goodsCatId','goods_cats.catId')
            ->where('attributes.attrName','like',"%$attrName%")
            ->select('attributes.*','goods_cats.catName')
            ->paginate(10);
    }
    public static function getOne($where=[]){
        return self::where($where)->first();
    }
    public static function attrDel($where=[]){
        return self::where($where)->delete();
    }
    public static function attrUpdate($where=[],$data){
        return self::where($where)->update($data);
    }
}

