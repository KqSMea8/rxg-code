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

class CouponController extends Controller
{

	public function coupon()
	{
		$userId = session()->get('userId');
		$model = new Coupon;
		$sql = $model->sele();
		var_dump($sql);die;
	}
}
