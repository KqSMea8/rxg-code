<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/12
 * Time: 11:22
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    protected $table = 'power';
    public $timestamps = false;
    public function roles(){
    return $this->hasMany('App\Http\Models\RolePower','powerId','powerId');
}
    public static function getPower($where=[]){
        return self::where($where)->first();
    }
    public static function getPowers($in){
        return self::where('status','=',1)
            ->whereIn('powerId',$in)
            ->get();
    }
    public static function getPs($where){
        return self::where($where)->get();
    }
    public static function powerAdd($data){
        return self::insert($data);
    }
    public static function powerDel($where){
        return self::where($where)->delete();
    }
    public static function getPsO($where){
        return self::where($where)->orderBy('path')->orderBy('parentId')->paginate(10);
    }
}








