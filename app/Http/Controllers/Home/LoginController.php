<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\RxgUser;
use App\Mail\UserRegister;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ShotMessageController;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    //登陆页面
    public function login()
    {
        if (Request::isMethod('POST')) {
            $data = Request::post();
            $password = base64_encode(md5(md5($data['password'])) . 'renxinggou');
            $findRes = RxgUser::checkUserLogin($data['username'], $password);
            if ($findRes) {
                session()->put('userId', $findRes->userId);
                session()->put('username', $findRes->username);
                return response()->json([
                    'code' => 1,
                    'message' => '登录成功'
                ]);
            } else {
                return response()->json([
                    'code' => 2,
                    'message' => '用户名或密码错误'
                ]);
            }
        } else {
            return view("home.login.login");
        }
    }

    public function qq_login()
    {
        return Socialite::with('qq')->redirect();
    }

    //注册页面
    public function register()
    {
        if (Request::isMethod('post')) {
            $postData = Request::post();
            if ($postData['_token'] !== csrf_token()) {
                return response()->json([
                    'code' => 2,
                    'message' => '非法注册，请您注意'
                ]);
            }
            unset($postData['_token']);
            unset($postData['rPassword']);
            if (array_key_exists('tel',$postData)) {
                $postData['username'] = $postData['tel'];
                unset($postData['telCode']);
                $findRes = RxgUser::checkTelOnly($postData['tel']);
                if ($findRes) {
                    return response()->json([
                        'code' => 2,
                        'message' => '该手机号已被注册'
                    ]);
                }
            } elseif (array_key_exists('email',$postData)) {
                $postData['username'] = $postData['email'];
                unset($postData['emailCode']);
                $findRes = RxgUser::checkEmailOnly($postData['email']);
                if ($findRes) {
                    return response()->json([
                        'code' => 2,
                        'message' => '该邮箱号已被注册'
                    ]);
                }
            }
            $postData['password'] = base64_encode(md5(md5($postData['password'])) . 'renxinggou');
            $addRes = RxgUser::register($postData);
            if ($addRes) {
                return response()->json([
                    'code' => 1,
                    'message' => '恭喜您！注册成功'
                ]);
            } else {
                return response()->json([
                    'code' => 2,
                    'message' => '抱歉，注册失败'
                ]);
            }
        } else {
//            echo session()->get('code');die;
            return view("home.login.register");
        }
    }

    //存个验证码时间
    public function codeTimePut()
    {
        $type = Request::get('type');
        session()->put($type, time() + 60);
        return response()->json([
            'code' => 1
        ]);
    }

    //判断输入的验证码是否成功
    public function checkCode()
    {
        $sessionCode = session()->get('code');
        $code = Request::get('code');
        if ($sessionCode == $code) {
            return response()->json([
                'code' => 1,
                'message' => '验证成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'message' => '验证码错误'
            ]);
        }
    }

    //发送邮件接口
    public function sendEmail()
    {
        $request = new \Illuminate\Http\Request();
        $code = rand(100000, 999999);
        $email = Request::get('email');
        session()->put('emailCodeTime', time() + 60);
        session()->put('code', $code);
        // Mail::send()的返回值为空，所以可以其他方法进行判断
        $res = Mail::to($email)->send(new UserRegister($code));
        return response()->json($res);
    }

    //退出登录
    public function loginOut()
    {
        session()->flush();
        return redirect('/');
    }

    //发送短信接口
    public function sendMessage()
    {
        $to = Request::get('tel');
        $code = rand(100000, 999999);
        session()->put('telCodeTime', time() + 60);
        session()->put('code', $code);
        $datas = [$code, 5];
        $tempId = 1;
        $res = $this->sendTemplateSMS($to, $datas, $tempId);
        return response()->json($res);
    }

    //发送短信模板
    public function sendTemplateSMS($to, $datas, $tempId)
    {
        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
        $accountSid = '8aaf070862181ad50162275bb9bf0954';

        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        $accountToken = '173e7750f60d4609acb900e7a57372b8';

        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        $appId = '8aaf070862181ad5016227624877099b';

        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
        $serverIP = 'app.cloopen.com';

        //请求端口，生产环境和沙盒环境一致
        $serverPort = '8883';

        //REST版本号，在官网文档REST介绍中获得。
        $softVersion = '2013-12-26';

        // 初始化REST SDK
        $rest = new ShotMessageController($serverIP, $serverPort, $softVersion);
        $rest->setAccount($accountSid, $accountToken);
        $rest->setAppId($appId);

        // 发送模板短信
        $result = $rest->sendTemplateSMS($to, $datas, $tempId);
        return $result;
        if ($result == NULL) {
            echo "result error!";
        }
        if ($result->statusCode != 0) {
            echo "error code :" . $result->statusCode . "<br>";
            echo "error msg :" . $result->statusMsg . "<br>";
            //TODO 添加错误处理逻辑
        } else {
            echo "Sendind TemplateSMS success!<br/>";
            // 获取返回信息
            $smsmessage = $result->TemplateSMS;
            echo "dateCreated:" . $smsmessage->dateCreated . "<br/>";
            echo "smsMessageSid:" . $smsmessage->smsMessageSid . "<br/>";
            //TODO 添加成功处理逻辑
        }
    }

}