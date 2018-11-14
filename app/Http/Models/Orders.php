<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "orders";
    public $timestamps = false;

    //支付成功后修改订单表中的字段  orderStatus  is_pay
    public function paySuccess($orderStatus,$is_pay,$orderNo)
    {
        $data=$this->where(["orderNo"=>$orderNo])->update(["orderStatus"=>$orderStatus,"isPay"=>$is_pay]);
        return $data;
        
        
    }
    
    //点击地址修改订单中相对应的地址
    public function updateAddress($orderId,$userName,$userPhone,$addressName)
    {
        $data=$this->where(["orderId"=>$orderId])->update(["userName"=>$userName,"userAddress"=>$addressName,"userPhone"=>$userPhone]);
        return $data;
        
    }
    
    //订单回收站
    public function recycle()
    {
        $data = $this->leftJoin("user", "user.userId", "orders.userId")
            ->leftJoin("shops", "shops.shopId", "orders.shopId")
            ->join("orders_goods", "orders_goods.ordersId", "orders.orderId")
            ->join("goods", "goods.goodsId", "orders_goods.goodsId")
            ->select("user.username", "orders.addTime", "orders.orderNo", "orders.payType", "orders.orderStatus", "goods.goodsName", "goods.goodsImg", "shops.shopTel", "shops.shopName", "orders.orderId", "goods.goodsId", "goods.shopPrice", "shops.shopId", "orders_goods.goods_num", "orders.isRefund","goods.goodsDesc")
            ->where(["is_show" => 0])
            ->where(["orders.userId"=>session()->get("userId")])
            ->orderby("orders.orderId")
            ->paginate(5);
        return $data;
    }
    
    
    //订单回收站还原 修改is_show=1
    public function restoreUpdate($orderId)
    {
       $data=$this->where(["orderId"=>$orderId])->update(["is_show"=>1]);
       return $data;
        
    }
    
    
    //后台搜索
    public function search($where, $where1)
    {
        $data = $this->join("user", "user.userId", "orders.userId")
            ->where($where)
            ->orwhere($where1)
            ->paginate(10);
        return $data;
    }

//我的订单
    public function orderData($keywords)
    {
        $data = $this->leftJoin("user", "user.userId", "orders.userId")
            ->leftJoin("shops", "shops.shopId", "orders.shopId")
            ->leftJoin("orders_goods", "orders_goods.ordersId", "orders.orderId")
            ->leftJoin("goods", "goods.goodsId", "orders_goods.goodsId")
            ->select("user.username", "orders.addTime", "orders.orderNo", "orders.payType", "orders.orderStatus", "goods.goodsName", "goods.goodsImg", "shops.shopTel", "shops.shopName", "orders.orderId", "goods.goodsId", "goods.shopPrice", "shops.shopId", "orders_goods.goods_num", "orders.isRefund","goods.goodsDesc")
            ->where(["is_show" => 1])
            ->where([["goods.goodsName", 'like', "%$keywords%"], ['orders.userId', session()->get("userId")]])
            ->orwhere([["orders.orderNo", '=', $keywords], ['orders.userId', session()->get("userId")]])
//                           ->orwhere()
                           ->paginate(5);
		return $data;
	}
        //订单详情
        public function content($id)
        {
           
		$data=$this->leftJoin("user","user.userId","orders.userId")
                           ->leftJoin("shops","shops.shopId","orders.shopId")
                           ->leftJoin("orders_goods","orders_goods.ordersId","orders.orderId")
                           ->leftJoin("goods","goods.goodsId","orders_goods.goodsId")
                           ->leftJoin("express","express.expressId","orders.expressId")
                           ->select("user.username","orders.addTime","orders.orderNo","orders.payType","orders.orderStatus","goods.goodsName","goods.goodsImg","shops.shopTel","shops.shopName","orders.orderId","orders.userAddress","orders.realTotalMoney","express.expressName","orders.userPhone","orders.orderScore","orders.orderRemarks")
                            
                           ->where(['orders.orderId'=>$id])
                           ->first();
		return $data;
        }
        
        //待付款
        public function pay($orderid)
        {
            $data=$this->leftJoin("user","user.userId","orders.userId")
                           ->leftJoin("shops","shops.shopId","orders.shopId")
                           ->join("orders_goods","orders_goods.ordersId","orders.orderId")
                           ->join("goods","goods.goodsId","orders_goods.goodsId")
                           ->leftJoin("express","express.expressId","orders.expressId")
->select("user.username","orders.addTime","orders.orderNo","orders.payType","orders.orderStatus","goods.goodsName","goods.goodsImg","shops.shopTel","shops.shopName","orders.orderId","orders.userAddress","orders.realTotalMoney","express.expressName","orders.userPhone","orders.orderScore","orders.orderRemarks","goods.goodsDesc","orders_goods.goods_num")
->where(["is_show"=>1])
                    ->where(['orders.orderStatus'=>$orderid,'orders.userId'=>session()->get("userId")])
                    ->paginate(5);
            return $data;
            
        }
        //待发货
        public function daifa($orderid)
        {
                      $data=$this->leftJoin("user","user.userId","orders.userId")
                           ->leftJoin("shops","shops.shopId","orders.shopId")
                           ->join("orders_goods","orders_goods.ordersId","orders.orderId")
                           ->join("goods","goods.goodsId","orders_goods.goodsId")
                           ->leftJoin("express","express.expressId","orders.expressId")
->select("user.username","orders.addTime","orders.orderNo","orders.payType","orders.orderStatus","goods.goodsName","goods.goodsImg","shops.shopTel","shops.shopName","orders.orderId","orders.userAddress","orders.realTotalMoney","express.expressName","orders.userPhone","orders.orderScore","orders.orderRemarks","goods.goodsDesc","orders_goods.goods_num")
->where(["is_show"=>1])
                              ->where(['orders.orderStatus'=>$orderid,'orders.userId'=>session()->get("userId")])
                    ->paginate(5);
            return $data;
            
        }
        //待收货
        public function daishou($orderid)
        {
             $data=$this->leftJoin("user","user.userId","orders.userId")
                           ->leftJoin("shops","shops.shopId","orders.shopId")
                           ->join("orders_goods","orders_goods.ordersId","orders.orderId")
                           ->join("goods","goods.goodsId","orders_goods.goodsId")
                           ->leftjoin("express","express.expressId","orders.expressId")
->select("user.username","orders.addTime","orders.orderNo","orders.payType","orders.orderStatus","goods.goodsName","goods.goodsImg","shops.shopTel","shops.shopName","orders.orderId","orders.userAddress","orders.realTotalMoney","express.expressName","orders.userPhone","orders.orderScore","orders.orderRemarks","goods.goodsDesc","orders_goods.goods_num")
->where(["is_show"=>1])
                     ->where(['orders.orderStatus'=>$orderid,'orders.userId'=>session()->get("userId")])
                    ->paginate(5);
            return $data;
            
        }
        
        //查看商品详情
        public function goodOne($id)
        {
            $data=$this->join("orders_goods","orders_goods.ordersId","orders.orderId")
                       ->join("goods","goods.goodsId","orders_goods.goodsId")
                       ->select("orders_goods.*","goods.*","orders.*")

                       ->where(["orders.orderId"=>$id])



                       ->get();
            return $data;
        }
        
        //店铺所有商品
        public function orderGood($id)
        {
            $data=$this->join("shops","shops.shopId","orders.shopId")
                       ->join("goods","goods.shopId","shops.shopId")
                       ->select("goods.*")
                       ->where(['goods.shopId'=>$id])
                       ->distinct("goods.goodsName")
                       ->get();
            return $data;
        }
        
        //删除/取消订单修改is_show为0
        public function resetOrders($id,$is_show)
        {
            $data=$this->where(["orderId"=>$id])->update(["is_show"=>0]);
            return $data;
            
        }
        
        //确认收货
        public function orderShouhuo($id)
        {
            $data=$this->where(['orderId'=>$id])->update(['orderStatus'=>2]);
            return $data;
        }
        
        //订单页面的立即支付
        public function orderPay($id)
        {
            $data=$this->leftJoin("orders_goods","orders.orderId","orders_goods.ordersId")
                       ->leftJoin("goods","orders_goods.goodsId","goods.goodsId")
                        ->where(['orders.orderId'=>$id])
                        ->get();
            return $data;
        }
	//后台详情
        public function adminContents($id)
        {
            $data=$this
                    ->join("user","user.userId","orders.userId")
                    ->join("shops","shops.shopId","orders.shopId")
                    ->where(["orderId"=>$id])->get();
            return $data;
        }


        //获取能够返现的数据
        public function getMoneyBackData($shopId)
        {
          return $this->where(['shopId'=>$shopId,'orderStatus'=>2,'isPay'=>1])->first();
        }
        

        public static function placeOrder($data){
            return self::insertGetId($data);
        }

        public function ordersales($id)
        {
          return $this->where(['orderNo'=>$id])->first();
        }
        
        public function orderDate($id,$data)
        {
          return $this->where(['orderId'=>$id])->update($data);
        }
        
        }

 