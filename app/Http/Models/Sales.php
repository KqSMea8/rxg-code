<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class Sales extends Model
{
   protected $table="orders";
   public function showData($keywords)
   {
      $data=$this->leftJoin("user","user.userId","orders.userId")
                           ->leftJoin("shops","shops.shopId","orders.shopId")
                           ->join("orders_goods","orders_goods.ordersId","orders.orderId")
                           ->join("goods","goods.goodsId","orders_goods.goodsId")
                           ->select("user.username","orders.addTime","orders.orderNo","orders.totalMoney","orders.payType","orders.orderStatus","goods.goodsName","goods.goodsImg","shops.shopTel","shops.shopName","orders.orderId","orders_goods.goods_num")
                           ->where(['orders.userId'=>1,'orders.isRefund'=>1])
                           ->where("goods.goodsName",'like',"%$keywords%")
                           ->orwhere("orders.orderNo",'=',"$keywords")
                           ->paginate(10);
                           // var_dump($data);die;
      return $data;
   }
   public function find($keywords,$orderId)
   {
      $data=$this->leftJoin("user","user.userId","orders.userId")
                           ->leftJoin("shops","shops.shopId","orders.shopId")
                           ->join("orders_goods","orders_goods.ordersId","orders.orderId")
                           ->join("goods","goods.goodsId","orders_goods.goodsId")
                           ->select()
                           ->where(['orders.userId'=>session()->get('userId'),'orders.orderId'=>$orderId])
                           ->where("goods.goodsName",'like',"%$keywords%")
                           ->orwhere("orders.orderNo",'=',"$keywords")
                           ->paginate(10);
                           // var_dump($data);die;
      return $data;
   }
 
}