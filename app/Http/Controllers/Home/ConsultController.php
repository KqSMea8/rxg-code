<?php 

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\Consult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Goods_cats;
use App\Http\Models\Orders;
use App\Http\Models\OrdersGoods;
use App\Http\Models\GoodsAppraises;
use App\Http\Models\Goods;
use Illuminate\Support\Facades\Request;

class ConsultController extends Controller
{
    public function consult()
	{
		$model = new Consult();
		$uname = Request::get('uname','');
		$arr = $model->sele($uname);
		$arr->appends(['activityName'=>$uname]);
        $catList = Goods_cats::getCatList();
		return view('home.consult.consult',[
            'data'=>$arr,
            'name'=>$uname,
            'catList'=>$catList
        ]);
	}
	//评价
	public function evaluate()
	{
		
		    // $userId = session()->get('userId');
		    // echo $userId;
		    $userId = 1;
		    $ordersData= Orders::where(['userId'=>$userId,'orderStatus'=>2])->get()->toArray();
			$ordersIds=[];
			foreach ($ordersData as $key => $value) {
				array_push($ordersIds,$value['orderId']);
			}
			$goodsData = OrdersGoods::whereIn('ordersId',$ordersIds)->get()->toArray();
			$goodsId=[];
			foreach ($goodsData as $key => $v) {
				array_push($goodsId,$v['goodsId']);
			}	
			$goods = Goods::whereIn('goodsId',$goodsId)->paginate(1);
        $catList = Goods_cats::getCatList();
			return view('home.consult.evaluate',[
			    'goods'=>$goods,
                'orderData'=>$ordersData,
                'catList'=>$catList
            ]);
	}

//分类
	public function add_evaluate_do()
	{
		$goodsId = Request::post('goodsId');
		// $userId = session()->get('userId');
		$userId = 1;
		$file = Request::file('images');
		$oldName = $file->getClientOriginalName();//文件原名称
        $lastName = $file->getClientOriginalExtension();//文件后缀名
        $oldPath=$file->getRealPath();//文件临时路径
        $fileName=date('Y-m-d H-i-s').'-'.uniqid().'.'.$lastName;
        $bool=Storage::disk('uploads/consult')->put($fileName,file_get_contents($oldPath));
        $data['images'] = "uploads/consult/".$fileName;
		$data['content'] = Request::post('content');
		$data['shopId'] = Request::post('shopId');
		$orderId = OrdersGoods::where('goodsId',$goodsId)->first();
		$data['orderId'] = $orderId->ordersId;
		$goodsData = Goods::where('goodsId',$goodsId)->first();
		$data['goodsSpecId'] = $goodsData['isSpec'];
		$data['goodsScore'] = Request::post('goodsScore');
		$data['createTime'] = date('Y-m-d H:i:s');
		$data['goodsId'] = $goodsId;
		$data['isShow'] = 1;
		$data['dataFlag'] = 1;
		$data['userId'] = $userId;
		$goodsAppraises = new GoodsAppraises;
		$result = $goodsAppraises->addData($data);
		$res = $result ? ['code'=>1,'message'=>'评价成功'] : ['code'=>0,'message'=>'评论失败'];
		return response()->json($res);
		// if ($result) {
		// 	return response()->json([
		// 		'code'=>1,
		// 		'message'=>'评论成功',
		// 		]);
		// }else{
		// 	return response()->json([
		// 		'code'=>0,
		// 		'message'=>'评论失败',
		// 		]);
		// }
	}

	public function classify()
	{
		return view('home.consult.classify');
	}
}

 ?>