<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class Area extends Model
{
    public $table="area";
    //查询出pid为0 的省
    public function province()
    {
        $data=$this->where(["parentId"=>1])->get();
        return $data;
        
    }
    public function orderCity($id)
    {
        $data=$this->where(['parentId'=>$id])->get();
        return $data;
        
    }
    //省
    public function provinceId($province)
    {
        $province1 = $this -> whereIn('id',$province)->select('areaName')->get();
        return $province1;
    }
    //市
   public function city($city)
    {
        $city1 = $this -> whereIn('id',$city)->select('areaName')->get();
        return $city1;
    }
    //县
    public function distruct($distruct)
    {
        $distruct1 = $this -> whereIn('id',$distruct)->select('areaName')->get();
        return $distruct1;
    }
    
    //查询单个省的名称
    public function provinceOne($province)
    {
        $province1=$this->where(["id"=>$province])->select("areaName")->first();
        return $province1;
        
    }
    
    public function cityOne($city)
    {
        $city1=$this->where(["id"=>$city])->first();
        return $city1;
    }
    public function distructOne($distruct)
    {
        $distruct1=$this->where(["id"=>$distruct])->first();
        return $distruct1;
    }
    
    //点击地址查询出相对应的名称
    public function areaName($qq)
    {
        $data=$this->whereIn("id",$qq)->get()->toArray();
        return $data;
    }
    
}
