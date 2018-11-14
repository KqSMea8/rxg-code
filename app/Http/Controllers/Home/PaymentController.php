<?php 
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
	//前台主页面
    public function payment()
    {
        return view("home.payment.payment");
    }
	//前台首页
	
}