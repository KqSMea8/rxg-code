<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/12
 * Time: 11:22
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';
    public $timestamps = false;
    public static function getOne($where=[]){
        return self::where($where)->pluck('roleId')->first();
    }
    public static function delData($where){
        return self::where($where)->delete();
    }
}