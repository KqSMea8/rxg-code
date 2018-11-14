<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/12
 * Time: 11:22
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class RolePower extends Model
{
    protected $table = 'role_power';
    public static function getRolePowers($where){
        return self::where($where)->pluck('powerId');
    }
    public static function getOne($where=[]){
        return self::where($where)->first();
    }
    public static function insertOne($data){
        return self::insert($data);
    }
    public static function delRolePower($where){
        return self::where($where)->delete();
    }
}