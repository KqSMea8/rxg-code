<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class AttributesValue extends Model
{
    protected $table='attr_value';
    
    public static function getAttrValue($attrId)
    {
       $data=self::where("aid",$attrId)->get();
       return $data;
    }


     //查询对应的属性值
   public static function attrValueById($id){
        return self::leftJoin('attributes','attr_value.aid','attributes.attrId')->whereIn('id',$id)->get();
    }
    
    public static function delAttrValue($attrId){
        return self::where('aid',$attrId)->delete();
    }
    
}

