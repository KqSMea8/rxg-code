<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class User extends Model
{
    protected $table="user";
    public $timestamps = false;
    public function userAddress($address_id)
    {
        $data=$this->where(["userId"=>session()->get('userId')])->update(["address_id"=>$address_id]);
        return $data;
        
    }
    
    //查询出用户表中的地址ID
    public function addressId()
    {
      $address_id=$this ->where(["userId"=>session()->get('userId')])->select("address_id")->get();
      
      return $address_id;
        
    }



public function sele($table,$id)
    {
        
         return DB::select("select * from $table where `userId`=$id");
    }
    public function up($table,$data,$where)
    {
        
        return DB::table($table)->where($where)->update($data);
    }

    
    
}



