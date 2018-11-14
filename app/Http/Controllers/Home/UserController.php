<?php 

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Goods_cats;
use Request;

class UserController extends Controller
{

	public function user()
	{
		$id = session()->get('userId');
		// var_dump($id);die;
		$model = new User();
		$sql = $model->sele('rxg_user',$id);
		$tel = $sql[0]->tel;
		$tel = substr($tel,0,3).'*****'.substr($tel,8,strlen($tel));
		$sql[0]->tel = $tel;
		// var_dump($tel);die;
        $catList = Goods_cats::getCatList();
		return view('home.user.user',[
		    'data'=>$sql,
            'catList'=>$catList
        ]);
	}
//修改密码
	public function userUp()
	{
		$id = $_GET['id'];
		$model = new User();
		$sql = $model->sele('rxg_user',$id);
        $catList = Goods_cats::getCatList();
		return view('home.user.userUp',[
		    'data'=>$sql,
            'catList'=>$catList
        ]);
	}
    
	public function userUpdate()
	{
		$pwd = input::post('password');
		// var_dump(base64_encode(md5(md5($pwd)).'renxinggou'));die;
		$data = input::post();
		unset($data['_token']);
		unset($data['passwd']);
		$id = $data['id'];
		// var_dump(base64_encode(md5(md5($data['pwd'])).'renxinggou'));die;
		$model = new User();
		$sql = $model->sele('rxg_user',$id);
		// var_dump($sql);die;
		if ($sql[0]->password==base64_encode(md5(md5($pwd)).'renxinggou') ) {
			$password = base64_encode(md5(md5($data['pwd'])).'renxinggou');
			$data['password'] = $password;
			unset($data['pwd']);
			unset($data['id']);
			// var_dump($id);die;
			$res = $model->up('user',$data,['userId'=>$id]);
			// var_dump($res);die;
			if ($res) {
				return redirect('user/user');
	    	} else {
	       	echo "修改失败!!!";
			}
		} else {
			echo "原密码错误!!!";
		}
	}
//修改手机号
	public function userTel()
	{
		$id = $_GET['id'];
		$model = new User();
		$sql = $model->sele('rxg_user',$id);
        $catList = Goods_cats::getCatList();
		return view('home.user.userTel',[
		    'data'=>$sql,
            'catList'=>$catList
        ]);
	}

	public function telUp()
	{
		$data = Request::post();
		unset($data['_token']);
		$tel = $data['tel'];
		$id = $data['id'];
		// var_dump($tel);die;
		$model = new User();
		$sql = $model->sele('rxg_user',$id);
		if ($sql[0]->tel==$tel) {
			$te = $data['phone'];
			$data['tel'] = $te;
			unset($data['phone']);
			unset($data['id']);
			// var_dump($id);die;
			$res = $model->up('user',$data,['userId'=>$id]);
			// var_dump($res);die;
			if ($res) {
				return response()->json([
	    		'code'=>1,
	    		'message'=>'修改成功!!!'
	    		]);
	    	} else {
	       	return response()->json([
	    		'code'=>2,
	    		'message'=>'修改失败!!!'
	    		]);
			}
		} else {
			return response()->json([
	    		'code'=>2,
	    		'message'=>'原手机号错误!!!'
	    		]);
		}
	}
	//用户中心
	public function userList()
	{
		$id = session()->get('userId');
		if ($id =  "") {
			return view('home.login.login');	
		}else{
            $catList = Goods_cats::getCatList();
			return view('home.user.userList',[
                'catList'=>$catList
            ]);
		}
	}

}

