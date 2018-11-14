<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Models\Admin;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login.login');
    }

    public function loginDo()
    {
        $postData = Request::post();
        if ($postData['_token'] != csrf_token()) {
            return response()->json([
                'code' => 2,
                'message' => '您正在进行非法登录'
            ]);
        }
        $rules = [
            'adminName' => 'required',
            'password' => 'required',
        ];
        $message = [
            'adminName.required' => '管理员名称必填',
            'password.required' => '密码必填',
        ];
        $validate = Validator::make($postData, $rules, $message);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            foreach ($errors as $k => $v) {
                return response()->json([
                    'code' => 2,
                    'message' => $errors[$k][0]
                ]);
            }
        }
        $findRes = Admin::getAdmin([
            'adminName' => $postData['adminName'],
            'password' => $postData['password']
        ]);
        if ($findRes) {
            session()->put('adminId', $findRes->adminId);
            session()->put('adminInfo', $findRes->adminName);
            return response()->json([
                'code' => 1,
                'message' => '登录成功'
            ]);
        } else
            return response()->json([
                'code' => 2,
                'message' => '用户名或密码不正确'
            ]);
    }

    public function loginOut()
    {
        session()->flush();
        return redirect('admin/login');
    }
}