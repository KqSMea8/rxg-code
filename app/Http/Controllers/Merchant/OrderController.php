<?php
/**
 * 订单控制器
 *
 * @author story_line
 */
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Models\Orders;
use App\Http\Models\RxgUser;
use Request;

class OrderController extends Controller
{
    /**
     * 订单列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function order()
    {
        $starttime = Request::get("starttime", "");
        $orderStatus = Request::get("orderStatus", "");
        $endtime = Request::get("endtime", "");
        $keywords = Request::get("keywords", "");
        $where = [];
        $where1 = [];
        $where[] = ['shopId', session()->get('shopId')];
        $where1[] = ['shopId', session()->get('shopId')];
        if (empty($starttime) && !empty($endtime)) {
            session()->put('timeError', "请完善开始时间");
            return back();
        } else if (!empty($starttime) && empty($endtime)) {
            session()->put('timeError', "请完善结束时间");
            return back();
        }
        if ($starttime > $endtime) {
            session()->put('timeError', "开始时间不能大于结束时间");
            return back();
        }


        if (!empty($starttime)) {
            $where[] = ["orders.addTime", ">", $starttime];
            $where[] = ["orders.addTime", "<", $endtime];
        }
        if (!empty($endtime)) {
            $where1[] = ["orders.addTime", ">", $starttime];
            $where1[] = ["orders.addTime", "<", $endtime];
        }

        if (!empty($orderStatus)) {
            $where[] = ['orders.orderStatus', $orderStatus];
            $where1[] = ['orders.orderStatus', $orderStatus];
        }

        $where[] = ['orders.orderNo', $keywords];
        $where1[] = ['user.username', 'like', "%$keywords%"];
        $model = new Orders();
        $data = $model->search($where, $where1);
        $data->appends('keywords', $keywords);
        $data->appends("orderStatus", $orderStatus);
        $data->appends("starttime", $starttime);
        $data->appends("endtime", $endtime);
        $status = [
            -3 => '用户拒收',
            -2 => '未付款',
            -1 => '取消订单',
            1 => '配送中',
            2 => '确认收货',
            3 => '待发货'
        ];

        return view('merchant.order.order', [
            'orderdata' => $data,
            "keywords" => $keywords,
            "orderStatus" => $orderStatus,
            "starttime" => $starttime,
            "endtime" => $endtime,
            'status' => $status
        ]);
    }

    /**
     * 订单详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function orderContent()
    {
        $id=Request::get("id");
        $model = new Orders();
        $data=$model->adminContents($id);

        return view("merchant.order.order_content",['data'=>$data]);
    }

    public function orderSales()
    {
        $id = Request::get('id');
        $model = new Orders;
        $sql = $model->ordersales($id);
        return view('merchant.order.orderSales',['data'=>$sql]);
    }

    public function orderUp()
    {
        $data = Request::post();
        unset($data['_token']);
        $data['isRefund'] = '1';
        $id = $data['orderId'];
        unset($data['cancelReason']);
        unset($data['orderId']);
        unset($data['remark']);
        $model = new Orders;
        $sql = $model->orderDate($id,$data);
       if ($sql) {
            return response()->json([
                'code'=>1,
                'message'=>'退款成功'
            ]);
        } else {
            return response()->json([
                'code'=>2,
                'message'=>'退款失败'
            ]);
        }
    }
}