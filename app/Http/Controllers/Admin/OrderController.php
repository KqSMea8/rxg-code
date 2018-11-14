<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Request;
use App\Http\Models\Orders;

class OrderController extends Controller
{
    //订单列表
    public function orderList()
    {
//        $orderStatus = empty(Request::get('orderStatus')) ? '' : Request::get('orderStatus');
//        $starttime=empty(Request::get('starttime')? date("Y-m-d",strtotime("-1 week")) : Request::get("starttime"));
//        $endtime= empty(Request::get("endtime") ? date("Y-m-d",time()) : Request::get("endtime"));
//        $keywords=empty(Request::get("keywords") ? "" : Request::get("keywords"));
        $starttime = Request::get("starttime", "");
        $orderStatus = Request::get("orderStatus", "");
        $endtime = Request::get("endtime", "");
        $keywords = Request::get("keywords", "");
        $where = [];
        $where1 = [];

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
//        dump($where);
//        dd($where1);
//
        if (!empty($orderStatus)) {
            $where[] = ['orders.orderStatus', $orderStatus];
            $where1[] = ['orders.orderStatus', $orderStatus];
        }


//        dd($where);
        $where[] = ['orders.orderNo', $keywords];
        $where1[] = ['user.username', 'like', "%$keywords%"];
        $model = new Orders();
        $data = $model->search($where, $where1);
        $data->appends('keywords', $keywords);
        $data->appends("orderStatus", $orderStatus);
        $data->appends("starttime", $starttime);
        $data->appends("endtime", $endtime);
        return view('admin.order.order', ['orderdata' => $data, "keywords" => $keywords, "orderStatus" => $orderStatus, "starttime" => $starttime, "endtime" => $endtime]);
    }
    //后台详情
        public function adminContent()
        {
            $id=Request::get("id");
            $model=new Orders();
            $data=$model->adminContents($id);
            return view("admin.order.order_content",['data'=>$data]);
            
            
        }
    
    
    
    public function responsive()
    {
        return view("admin.order.responsive");
    }

}

