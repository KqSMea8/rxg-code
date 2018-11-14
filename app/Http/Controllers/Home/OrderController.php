<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\Cart;
use App\Http\Models\Goods;
use App\Http\Models\Orders;
use App\Http\Models\Address;
use App\Http\Models\Area;
use App\Http\Models\OrdersGoods;
use App\Http\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use App\Http\Models\Goods_cats;

class OrderController extends Controller
{
    //支付接口
    
 public function alipay()
 {
     $orderNo = Request::all();
    $catList = Goods_cats::getCatList();
     return view("home.order.index",['orderNo'=>$orderNo,"catList"=>$catList]);

 }
    public function pagepay()
    {
        $data=Request::all();
        
        return view("home.order.pagepay",["data"=>$data]);
    }
    //支付宝支付
     public function alipayResult(){
        $payRes = Request::all();
        $orderNo=$payRes["out_trade_no"];
        if($payRes)
        {
           $model=new Orders();
           $orderStatus=3;
           $is_pay=1;
           $data=$model->paySuccess($orderStatus,$is_pay,$orderNo);
           return redirect("order/index");
           
            
            
        }
        else
        {
            return redirect("order/index");
            
        }
        
        return redirect("order/index");


    }
    //用户退款
    public function refund(){
        return view('home.order.refund');
    }
    
    
    //订单回收站
    public function recycle()
    {
        $model=new Orders();
        $data=$model->recycle();
        $catList = Goods_cats::getCatList();
        return view("home.order.recycle",['data'=>$data,"catList"=>$catList]);
    }
// 我的订单
    public function index()

	{

            $keywords=Request::get('keywords','');
            $model=new Orders();
            //查询出订单表中的数据
            $data=$model->orderData($keywords);
            $data->appends(['shopName'=>$keywords]);
        $catList = Goods_cats::getCatList();
            return view("home.order.order",[
                'data'=>$data,
                "keywords"=>$keywords,
                'catList'=>$catList
            ]);
	}
        
    //确认支付
    public function orderAdd()
    {
        //根据id查询出对应的商品信息
    $id=Request::get("id");
    $model=new Orders();
    $data=$model->orderPay($id);
    //查询出所有的省
    $area=new Area();
    $provinceAll=$area->province();            
    //查询地址表中所有的数据
    $address=new Address();
    $allAddress=$address->allAddress();
        $catList = Goods_cats::getCatList();
    //如果查询出的地址不为空则显示地址
    if(!$allAddress->isEmpty())
    {
        //查询出地址表中省市区所对应的名称
        foreach ($allAddress as $k=>$v){
            $v->provinceName = $area->provinceOne($v->province)->areaName;
            $v->cityName = $area->cityOne($v->city)->areaName;
            $v->distructName = $area->distructOne($v->distruct)->areaName;

        }
        //查出用户表中的地址ID并且设为默认地址
        $user=new User();
        $addressId=$user->addressId();
//        dd($provinceName);
        return view("home.order.orderAdd",[
            'data'=>$data,
            "area"=>$provinceAll,
            "address"=>$allAddress,
            "address_id"=>$addressId,
            'catList'=>$catList
        ]);
         }
         
         else{
        return view("home.order.orderAdd",[
            'data'=>$data,
            "area"=>$provinceAll,
            "address"=>$allAddress,
            'catList'=>$catList
        ]);
        }
        }
    //修改用户表中的address_id

    public function updateAddressId()
    {
        if (Request::ajax()) {

            $address_id = Request::post("address_id");
            //点击地址添加到订单表中的地址
            $addressData=new Address();
            $orderAddress=$addressData->addressId($address_id);
            $address=$orderAddress->province." ".$orderAddress->city." ".$orderAddress->distruct;
            $qq= explode(" ",$address);
            //实例化area模型
            $area=new Area();
            $areaName=$area->areaName($qq);  
            $province=$areaName[0]["areaName"];
            $city=$areaName[1]["areaName"];
            $distruct=$areaName[2]["areaName"];
            
            $addressName=$province.$city.$distruct;
            $userName=$orderAddress->user_name;
            $userPhone=$orderAddress->tell;
            $orderId=$orderAddress->order_id;
            //实例化订单表
            $order=new Orders();
            $orderData=$order->updateAddress($orderId,$userName,$userPhone,$addressName);
            $user = new User();
            $address = $user->userAddress($address_id);
            return response()->json([
                'code' => 1,
                'message' => '修改成功'

            ]);
        }
    }


    //三级联动查看市
    public function city()
    {
        $id = Request::get('id');
        $model = new Area();
        $data = $model->orderCity($id);
        return $data;
    }

    //三级联动县
    public function distruct()
    {
        $id = Request::get('value');
        $model = new Area();
        $data = $model->orderCity($id);
        return $data;
//		return view("home.order.orderAdd",['data'=>$data]);
	}

    //新地址
    public function newAddress()
    {
        $userId = session()->get('userId');
        $data = Request::all();
        $province = $data['province'];
        $city = $data['city'];
        $distruct = $data['distruct'];
        $model=new Address();
        $sqldata = $model->addressAdd($data);
        $area = new Area();
        $areaData['provinceId'] = $area->provinceOne($province)->areaName;
        $areaData['cityId'] = $area->cityOne($city)->areaName;
        $areaData['distructId'] = $area->distructOne($distruct)->areaName;
        return response()->json([
            'code' => 1,
            'message' => '成功',
            'data' => $areaData
        ]);

    }


    //订单详情
    public function orderContent()
    {

        $model = new Orders();
        $id = Request::get("id");
        $data = $model->content($id);
        $catList = Goods_cats::getCatList();
        return view("home.order.orderContent", [
            'data' => $data,
            'catList'=>$catList
        ]);
    }

    //待付款
    public function daiPay()
    {
        $orderid = Request::get('id');
        $model = new Orders();
        $data = $model->pay($orderid);
        $data->appends(["id"=>$orderid]);
        $catList = Goods_cats::getCatList();
        return view("home.order.orderPay", [
            'data' => $data,
            'catList'=>$catList
        ]);
    }

    //待发货
    public function daifa()
    {
        $orderid = Request::get('id');
        $model = new Orders();
        $data = $model->daifa($orderid);
        $catList = Goods_cats::getCatList();
        $data->appends(["id"=>$orderid]);
        return view("home.order.orderDaifa", [
            'data' => $data,
            'catList'=>$catList
        ]);
    }

    //待收货
    public function daishou()
    {
        $orderid = Request::get('id');
        $model = new Orders();
        $data = $model->daishou($orderid);
        $catList = Goods_cats::getCatList();
        $data->appends(["id"=>$orderid]);
        return view("home.order.orderDaishou", [
            'data' => $data,
            'catList'=>$catList
        ]);
    }

    //物流跟踪
    public function logistics()
    {
        $catList = Goods_cats::getCatList();
        return view("home.order.logistics",[
            'catList'=>$catList
        ]);
    }

    //查看商品的详情
    public function goodContent()
    {
        $model = new Orders();
        $id = Request::get("id");
//                var_dump($id);die;
        $data = $model->goodOne($id);

//                var_dump($data);
        $catList = Goods_cats::getCatList();
        return view("home.order.orderGoodcontent", [
            'data' => $data,
            'catList'=>$catList
        ]);
    }

    //查看店铺中的商品
    public function shopGoods()
    {
        $id = Request::get('id');
        $model = new Orders();
        $data = $model->orderGood($id);
        $catList = Goods_cats::getCatList();
        return view("home.order.orderShop", [
            'data' => $data,
            'catList'=>$catList
        ]);

    }

    //取消订单
    public function resetOrder()
    {
        $model = new Orders();
        $id = Request::get("id");
        $is_show = $model->is_show = 0;
        $data = $model->resetOrders($id,$is_show);
        $catList = Goods_cats::getCatList();
        return redirect("order/index");
    }

    //确认收货
    public function orderHuo()
    {
        $model = new Orders();
        $id = Request::get('id');

        $data = $model->orderShouhuo($id);
        $catList = Goods_cats::getCatList();
        return redirect("order/index");

    }

    //新增收货地址
    public function address()
    {
        $data = Request::all();
        return response()->json([
            "code" => 1,
            "message" => "成功"
        ]);
    }


    //用户购买商品后下订单
    public function placeOrder(){
        $data['orderNo'] = $this->orderNo();
        $data['userId'] = session()->get('userId');
        $data['orderStatus'] = Request::post('orderStatus');
        $data['goodsMoney'] = Request::post('goodsMoney');
        $data['deliverType'] = Request::post('deliverType');
        $data['totalMoney'] = Request::post('totalMoney');
        $data['realTotalMoney'] = Request::post('realTotalMoney');
        $data['addTime'] = date('Y-m-d H:i:s');
        $orderGoods = [];
        $num = Request::post('num');
        $goodsId = Request::post('goodsId');
        $shopId = Request::post('shopId');
        $cartId = Request::post('cartId');
        DB::beginTransaction();
        try{
            $orderId = Orders::placeOrder($data);
//            dd($orderId);
            foreach ($num as $k=>$v) {
                $orderGoods[$k] = [
                    'goodsId'=>$goodsId[$k],
                    'ordersId'=>$orderId,
                    'goods_num'=>$num[$k],
                    'shopId'=>$shopId[$k]
                ];
            }
            OrdersGoods::orderGoodsAdd($orderGoods);
            if(!empty($cartId)){
                Cart::cartDel($cartId);
            }
            DB::commit();
            return response()->json([
                'code'=>1,
                'msg'=>'下单成功',
                'orderId'=>$orderId
            ]);
        }catch (QueryException $e){
            DB::rollback();
            return response()->json([
                'code'=>0,
                'msg'=>'下单失败'
            ]);
        }
    }
    //订单编号
    public function orderNo()
    {
        $time=date("Y-m-d H:i:s",time());

        $id= session()->get("userId");
        if(strlen($id)>=4)
        {
            $orderid= substr($id,-4);

        }
        else
        {
            $orderid=$id;
        }
        $date= strtotime($time).$orderid;
        
        $num= rand(1,99999);
        $datetime= str_pad($date,16,$num);
        return $datetime;
    } 
            //订单回收站还原订单
           public function restoreOrder()
           {
               $orderId=Request::get("id");
               $model=new Orders();
               $data=$model->restoreUpdate($orderId);
               return redirect("order/recycle");
               
           }
}
