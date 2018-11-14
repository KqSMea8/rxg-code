<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/15
 * Time: 13:26
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    protected $table = 'admin';
    public $timestamps = false;
    public static function getAdmins($where=[]){
        return self::join('admin_role','admin.adminId','admin_role.adminId')
            ->join('role','admin_role.roleId','role.roleId')
            ->where($where)->select('admin.*','role.roleName','admin_role.roleId')
            ->paginate(10);
    }
    public static function adminAdd($data){
        return self::insert($data);
    }
    public static function getAdmin($where){
        return self::where($where)->first();
    }
    public static function adminDel($where){
        return self::where($where)->delete();
    }
}