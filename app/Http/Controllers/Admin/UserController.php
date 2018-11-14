<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Models\RxgUser;
class UserController extends Controller
{
	public function userList(){
		$keyword = Request::get('keyword');
    	$model = new RxgUser();
    	$sql = $model->where('username','like','%'.$keyword.'%')->Orwhere('trueName','like','%'.$keyword.'%')->Orwhere('tel','like','%'.$keyword.'%')->paginate(10);
    	$sql->appends(['keyword' => $keyword]);
        return view('admin.user.userList',['data' => $sql,'keyword' => $keyword]);
		
	}
	public function userShowChange()
    {
        $userId = Request::get('userId');
        $status = Request::get('status');
        $res = (new RxgUser())->where(['userId'=>$userId])->update(['status' => $status]);
        if($res){
            return response()->json(['code' => 1,'msg' => '修改成功']);
        }else{
            return response()->json(['code' => 0,'msg'=>'修改失败']);
        }
    }
}
