<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Logistics extends Model
{
    protected $table = "logistics";
    public $timestamps = false;
    //添加
    public function insertData($data)
    {
    	return self::insert($data);
    }
    
    public static function getUser($where=[])
    {
        return self::where($where)->first();
    }
    
    public static function getPs($where)
    {
        return self::where($where)->get();
    }
}
