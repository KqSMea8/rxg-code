<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class OrdersGoods extends Model
{
	protected $table='orders_goods';
	public static function orderGoodsAdd($data){
	    return self::insert($data);
    }
} 