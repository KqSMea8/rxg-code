<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Site extends Model
{
    public $timestamps = false;
    public $table="address";
    public function insertData($data)
    {
            $data=$this->insert($data);
            return $data;
    }
    public function select($table)
    {
        return DB::select("select * from $table where user_id = 1");
    }
    //删除
    public static function addressDel($where){
        return self::where($where)->delete();
    }
    public function upd($id,$data)
    {
        return self::where(['id'=>$id])->update($data);
    }
}

