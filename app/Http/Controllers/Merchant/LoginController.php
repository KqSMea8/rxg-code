<?php
/**
 * 店铺登录控制器
 *
 * @author story_line
 */
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Models\Shops;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /**
     * 店铺登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index()
    {
        return view('merchant.login.login');
    }

    /**
     * 登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginDo()
    {
        $postData = Request::all();
        if($postData['_token']!=csrf_token()){
            return response()->json([
                'code'=>2,
                'message'=>'您正在进行非法登录'
            ]);
        }
        unset($postData['_token']);
        $rules = [
            'shopName' => 'required',
            'pwd' => 'required',
        ];
        $message = [
            'shopName.required'=>'管理员名称必填',
            'pwd.required'=>'密码必填',
        ];
        $validate = Validator::make($postData, $rules,$message);
        if($validate->fails()){
            $errors = $validate->errors()->toArray();
            foreach ($errors as $k=>$v){
                return response()->json([
                    'code'=>2,
                    'message'=>$errors[$k][0]
                ]);
            }
        }
        $postData['pwd'] = md5($postData['pwd']);
        $shops = new Shops();
        $res = $shops->where($postData)->first();
        if($res){
            session()->put('shopId',$res->shopId);
            session()->put('shopInfo',$res);
            return response()->json([
                'code'=>1,
                'message'=>'登录成功'
            ]);
        }else{
            return response()->json([
                'code'=>2,
                'message'=>'用户名或密码不正确'
            ]);
        }
    }

    /**
     * 登出
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\think\response\Redirect
     */
    public function loginOut()
    {
        session()->flush();
        return redirect('merchant/login');
    }
}