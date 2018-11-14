<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/23
 * Time: 14:27
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    public $timestamps = false;
    public static function getUserCart($userId){
        return self::where('carts.userId',$userId)
            ->leftJoin('goods','carts.goodsId','goods.goodsId')
//            ->leftJoin('user','carts.userId','user.userId')
            ->select('carts.*','goods.goodsImg','goods.goodsName','goods.goodsDesc','goods.shopPrice','goods.shopId')
            ->get();
    }
    public static function updNum($cartId,$num){
        return self::where('cartId',$cartId)->update(['num'=>$num]);
    }
    public static function cartDel($cartId){
        $delRes = self::whereIn('cartId',$cartId)->delete();
        if ($userId = session()->get('userId')) {
            $cartNum = Cart::getNum($userId);
            session()->put('cartNum', $cartNum);
        }
        return $delRes;
    }
    public static function updCheck($isCheck,$cartId){
        return self::whereIn('cartId',$cartId)->update(['isCheck'=>$isCheck]);
    }
    public static function getNum($userId){
        return self::where('userId',$userId)->count();
    }
}