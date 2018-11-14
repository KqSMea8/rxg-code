<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/12
 * Time: 11:22
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    public $timestamps = false;
    public static function getRoles($where=[]){
        return self::where($where)->get();
    }
    public static function checkRoleName($roleName){
        return self::where('roleName',$roleName)->first();
    }
    public static function roleAdd($data){
        return self::insert($data);
    }
    public static function roleDel($where){
        return self::where($where)->delete();
    }
}