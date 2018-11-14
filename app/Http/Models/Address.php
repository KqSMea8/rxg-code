<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class Address extends Model
{
    public $table="address";
    public $timestamps = false;
    
    public function addressAdd($data)
    {
        $data=$this->insert($data);
        return $data;
    }

    //统计地址表用户为当前用户的地址条数
    public function addressSel()
    {
        $data=$this->where(["user_id"=>session()->get("userId")])->count();
        return $data;
    }
    //查询所有的地址
    public function allAddress()
    {
        $data=$this->where(["user_id"=>session()->get('userId')])->limit(3)->get();

        return $data;
    }
    public function allAddre()
    {
        $data=$this->where(["user_id"=>session()->get('userId')])->get();
        return $data;
    }
    public static function oneAddress($userId){
        return self::where('user_id',$userId)->first();
    }
    
    //根据地址ID查询出对应的地址
    public function addressId($address_id)
    {
        $data=$this->where(["id"=>$address_id])->first();
        return $data;
        
    }
}

