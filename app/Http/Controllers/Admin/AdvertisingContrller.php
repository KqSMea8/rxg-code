<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Advertising;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
class AdvertisingContrller extends Controller
{

    public function advertisingList()
    { 
    	$model = new Advertising;
	    $sql = $model->sele();
    	$uname = Request::get("username","");
	    $arr = $model->seek($uname);
		$arr->appends(["username"=>$uname]);
	    // var_dump($sql);die;
	    return view('admin.advertising.advertisingList',['data'=>$sql,'data'=>$arr,'name'=>$uname]);
    }
//广告添加页
	public function advertisingShow()
	{
		$model = new Advertising;
		$sql = $model->select('rxg_province');
	    return view('admin.advertising.advertising',['data'=>$sql]);
	}
//添加广告
	public function advertisingAdd()
	{
	    $data = Request::all();
	    $time = explode(" - ",$data['time']);
	    $starttime = $time[0];
	    $endtime = $time[1];
	    $data['stime'] = $starttime;
	    $data['otime'] = $endtime;
	    $data['img'] = Request::file('img');
	    // var_dump($data);die;
	     $rules = [
            'uname' => 'required',
            'type' => 'required',
        ];
        $message = [
	        'uname.required'=>'广告名称必填',
	        'type.required'=>'请选择媒介类型',
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
	    $originalName = $data['img']->getClientOriginalName(); // 文件原名
	    $ext = $data['img']->getClientOriginalExtension(); 
	    $realPath = $data['img']->getRealPath();
	    $filename = date("Y-m-d-H-i-s") . '-' . uniqid() . '.' . $ext;
	    $bool = Storage::disk('uploads/advertising')->put($filename,file_get_contents($realPath));
	    $data['img'] = 'uploads/advertising/'.$filename;
	    unset($data['_token']);
	    unset($data['time']);
	    // var_dump($data);die;
	    $model = new Advertising;
	    $sql = $model->inset('advertising',$data);
	    // var_dump($sql);die;
	    if ($sql) {
	    	return response()->json([
	    		'code'=>1,
	    		'message'=>'添加成功'
	    		]);
	    } else {
	        return response()->json([
	    		'code'=>2,
	    		'message'=>'添加失败'
	    		]);
	    }
	   
	}
//删除
	public function del()
	{
	    $id = $_GET['id'];
	    // var_dump($id);die;
	    $model = new Advertising;
	    $sql = $model->dele("rxg_advertising"," `aid` = '$id' ");
	    // var_dump($sql);die;
	    if ($sql) {
	        return response()->json([
	        	'code'=>1,
	        	'message'=>'删除成功'
	        ]);
	    } else {
	        return response()->json([
	        	'code'=>2,
	        	'message'=>'删除失败'
	        ]);
	    }
	    
	}
//修改
	public function up()
	{
	    $id = $_GET['id'];
	    $model = new Advertising;
		$res = $model->select('rxg_province');
	    $sql = $model->find("rxg_advertising","`aid` = $id");
	    $sql[0]->time = $sql[0]->stime.' - '.$sql[0]->otime;
	    // var_dump($sql);die;
	    return view('admin.advertising.advertisingUp',['data'=>$sql],['arr'=>$res]);
	}

	public function advertisingUpdate()
	{
	    $id = input::post('id');
	    $data = Request::all();
	    $time = explode(" - ",$data['time']);
	    $starttime = $time[0];
	    $endtime = $time[1];
	    $data['stime'] = $starttime;
	    $data['otime'] = $endtime;
	    $data['img'] = Request::file('img');
	    $image = input::post('image');
	    // var_dump($data['image']);die;

	    $rules = [
		    'uname' => 'required',
		    'type' => 'required',
	    ];
        $message = [
		        'uname.required'=>'广告名称必填',
		        'type.required'=>'请选择媒介类型',
        ];
	    // var_dump($data['img']);die;
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

	    if ($data['img']!='') {
	    	$originalName = $data['img']->getClientOriginalName(); // 文件原名
		    $ext = $data['img']->getClientOriginalExtension(); 
		    $realPath = $data['img']->getRealPath();
		    $filename = date("Y-m-d-H-i-s") . '-' . uniqid() . '.' . $ext;
		    $bool = Storage::disk('uploads/advertising')->put($filename,file_get_contents($realPath));
		    $data['img'] = 'uploads/advertising/'.$filename;
		    unset($data['_token']);
		    unset($data['id']);
		    unset($data['image']);
		    unset($data['time']);
		    $model = new Advertising;
		    $sql = $model->up('advertising',$data,['aid'=>$id]);
		    // var_dump($sql);die;
		    if ($sql) {
		    	return response()->json([
		    		'code'=>1,
		    		'message'=>'修改成功'
		    		]);
		    } else {
		        return response()->json([
		    		'code'=>2,
		    		'message'=>'修改失败'
		    		]);
		    }
	    } else if (empty($data['img'])) {
	    	// var_dump($id);die;
	    	$data['img']=$image;
	    	// var_dump($data['img']);die;
	    	unset($data['_token']);
		    unset($data['id']);
		    unset($data['image']);
		    unset($data['time']);
		    // var_dump($data);die;
		    $model = new Advertising;
		    $sql = $model->up('advertising',$data,['aid'=>$id]);
		    // var_dump($sql);die;
		    if ($sql) {
		    	return response()->json([
		    		'code'=>1,
		    		'message'=>'修改成功'
		    		]);
		    } else {
		        return response()->json([
		    		'code'=>2,
		    		'message'=>'修改失败'
		    		]);
		    }
	    } 
	}
//批删
	public function advertisingDel()
	{
	    $id = input::post('item');
	    // var_dump($v);die;
	    $model = new Advertising;
	    $arr = implode(",",$id);
	    // var_dump($arr);die;
	    $sql = $model->delet('rxg_advertising',"`id` in ($arr)");
	    // var_dump($sql);die;
	    if ($sql) {
	        return redirect('admin/advertising/advertisingList');
	    } else {
	        echo "删除失败";
	    }
	}





}