<?php 

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\Sales;
use App\Http\Models\Goods_cats;
use App\Http\Models\Advertising;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

class SalesController extends Controller
{
	// 退货记录
	public function salesList()
	{
		$keywords=Request::get('keywords','');
		$model = new Sales();
		$sql = $model->showData($keywords);
		$sql->appends(['goodsName'=>$keywords]);
		$catList = Goods_cats::getCatList();
		return view('home.sales.salesList',[
			'data'=>$sql,
			"keywords"=>$keywords,
			"catList"=>$catList
			]);
	}
	// 退货
	public function sales()
	{
		$orderId = $_GET['id'];
		$keywords=Request::get('keywords','');
		$model = new Sales();
		$sql = $model->find($keywords,$orderId);
		$arr = $sql[0]->shopPrice;
		$sql[0]->totalMoney = $arr*$sql[0]->goods_num+20;
		$sql->appends(['goodsName'=>$keywords]);
		$catList = Goods_cats::getCatList();
		return view('home.sales.sales',[
			'data'=>$sql,
			"keywords"=>$keywords,
			'catList'=>$catList
			]);
	}
	
	public function salesUp()
	{
		$data = input::post();
		// var_dump($data);die;
		$data['isRefund'] = '2';
		$id = $data['id'];
		unset($data['id']);
		$rules = [
			'cancelReason' => 'required',
		];
		$message = [
			'cancelReason.required' => '请选择退款原因',
		];
		$validate = Validator::make($data,$rules,$message);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            foreach ($errors as $k=>$v){
                return response()->json([
                    'code'=>2,
                    'message'=>$errors[$k][0]
                ]);
            }
        }
		$model = new Advertising();
		$sql = $model->upda('orders',$data,['orderId'=>$id]);
		 if ($sql) {
	    	return response()->json([
	    		'code'=>1,
	    		'message'=>'申请成功'
	    		]);
	    } else {
	        return response()->json([
	    		'code'=>2,
	    		'message'=>'申请失败'
	    		]);
	    }
	}
}

 ?>