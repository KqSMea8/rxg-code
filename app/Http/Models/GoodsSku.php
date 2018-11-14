<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsSku extends Model
{
    public $table="sku";
    public $timestamps = false;
    //删除sku一条数据
    public function delSku($id)
    {
        $data=$this->where(["id"=>$id])->delete();
        return $data;
    }
    
    //根据attrid 查询一条数据
    public function goodsSkuOne($attr_values)
    {
        $data=$this->where(["attr_values"=>$attr_values])->first();
        return $data;
        
    }
    
    
    public function skuNum($goodsId)
    {
        $num=$this->where("goodsId",$goodsId)->groupBy("goodsId")->sum("num");
        return $num;
        
    }
    
    //查询一条的sku
    public function skuFirst($id)
    {
        $first=$this->where(["goodsId"=>$id])->get()->toArray();
        return $first;
    }
    
    //查询出sku表中所有的数据
    public function skuData()
    {
        $data=$this->get();
        return $data;
        
    }
    
    //添加sku
    public function addSku($skudata)
    {
        $data=$this->insert($skudata);
        return $data;
    }
    
    //查询一条数据
    public function skuOne($skudata)
    {
        $sku=$this->where([
                
                ["goodsId",$skudata['goodsId']],
                ["attr_values",$skudata['attr_values']]
                ])->first();
        return $sku;
        
    }
    
    
}