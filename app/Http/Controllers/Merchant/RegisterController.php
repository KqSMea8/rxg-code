<?php

namespace App\Http\Controllers\Merchant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
	//入驻页面
    public function register()
    {
    	return view("merchant.register.register");
    }
    public function registerDo()
    {
        $data = Request::post();
    }

}
?>