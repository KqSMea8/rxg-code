<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Brand;
use App\Http\Models\Advertising;
use App\Http\Models\Goods_cats;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
class BrandController extends Controller
{
//品牌列表
	public function brandList()
	{
		$model = new Brand();
		$uname = Request::get('username',"");
		$sql = $model->getBrand($uname);
		$sql->appends(["username"=>$uname]);
		// var_dump($sql);die;
		return view('admin.brand.brand',['data'=>$sql,'uname'=>$uname]);
	}
//品牌修改
	public function up()
	{
		$id = $_GET['id'];
		$model = new Brand;
		$res = $model->sele('rxg_goods_cats');
		$sql = $model->up($id);
        $goodsCatsModel = new Goods_cats();
        $catList = $goodsCatsModel->get()->toArray();
        $parentId3 = $goodsCatsModel->getOne($sql['catId']);
        $catList3 = $goodsCatsModel->getSons($parentId3['parentId'])->toArray();
        $parentId2 = $goodsCatsModel->getOne($catList3[0]['parentId']);
        $catList2 = $goodsCatsModel->getSons($parentId2['parentId'])->toArray();
        $parentId1 = $goodsCatsModel->getOne($catList2[0]['parentId']);
        $catList1 = $goodsCatsModel->getSons($parentId1['parentId'])->toArray();
		return view('admin.brand.brandUp',[
		    'data'=>$sql,
            'arr'=>$res,
            'catList' => $catList,
            'parentId1'=>$parentId1,
            'parentId2'=>$parentId2,
            'parentId3'=>$parentId3,
            'catList1'=>$catList1,
            'catList2'=>$catList2,
            'catList3'=>$catList3,
        ]);
	}

	public function brandUp()
	{
		$id = input::post('brandId');
	    $data = Request::post();
	    $data['time'] = date("Y-m-d H:i:s");
	    $data['brandImg'] = Request::file('brandImg');
	    $image = input::post('img');
	    $rules = [
		    'brandName' => 'required',
		    'catId' => 'required',
	    ];
        $message = [
		        'brandName.required'=>'品牌名称必填',
		        'catId.required'=>'请选择品牌类型',
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

	    if ($data['brandImg']!='') {
	    	$originalName = $data['brandImg']->getClientOriginalName(); // 文件原名
		    $ext = $data['brandImg']->getClientOriginalExtension(); 
		    $realPath = $data['brandImg']->getRealPath();
		    $filename = date("Y-m-d-H-i-s") . '-' . uniqid() . '.' . $ext;
		    $bool = Storage::disk('uploads/advertising')->put($filename,file_get_contents($realPath));
		    $data['brandImg'] = 'uploads/advertising/'.$filename;
		    unset($data['_token']);
		    unset($data['id']);
		    unset($data['img']);
		    // var_dump($data);die;
		    $model = new Advertising;
		    $sql = $model->up('brand',$data,['brandId'=>$id]);
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
	    } else if (empty($data['brandImg'])) {
	    	$data['brandImg']=$image;
	    	unset($data['_token']);
		    unset($data['id']);
		    unset($data['img']);
		    $model = new Advertising;
		    $sql = $model->up('brand',$data,['brandId'=>$id]);
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


    //添加品牌
    public function brandAdd()
    {
        $goods_cats = new Goods_cats;
        $parentCat = $goods_cats->getCatList();
        $goodsCats = $goods_cats->get()->toArray();
        return view('admin.brand.brandAdd', [
            'goodscats' => $goodsCats,
            'parentCat'=>$parentCat
        ]);
    }
    //后台执行添加品牌
    public function addDo()
    {
        $data = Request::post();
        $data['brandImg'] = Request::file('brandImg');
        $rules = [
            'brandName' => 'required',
            'brandImg' => 'required',
            'brandDesc' => 'required',
            'status' => 'required',
            'catId' => 'required'
        ];
        $message = [
            'brandName.required' => '品牌名称不能为空',
            'brandImg.required' => '品牌图片不能为空',
            'brandDesc.required' => '品牌描述不能为空',
            'status.required' => '是否可用必填',
            'catId.required' => '品牌分类不能为空'
        ];
        $validate = validator::make($data, $rules, $message);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            foreach ($errors as $key => $v) {
                return response()->json([
                    'code' => 2,
                    'message' => $errors[$key][0]
                ]);
            }
        }
        unset($data['_token']);
        $file = $data['brandImg'];
        $oldName = $file->getClientOriginalName();//文件原名称
        $lastName = $file->getClientOriginalExtension();//文件后缀名
        $oldPath = $file->getRealPath();//文件临时路径
        $fileName = date('Y-m-d H-i-s').'-'.uniqid().'.'.$lastName;
        $bool = Storage::disk('uploads/brand')->put($fileName, file_get_contents($oldPath));
        $data['brandImg'] = "uploads/brand/".$fileName;
        $data['status'] = 1;
        $data['addTime'] = date('Y-m-d H:i:s');
        $brand = new Brand;
        $res = $brand->addData($data);
        if ($res) {
            return response()->json([
                'code' => 1,
                'message' => '添加成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'message' => '添加失败'
            ]);
        }
    }

    //删除
    public function brandDel()
    {
        $id = Request::get('id');
        $delRes = Brand::delData(['brandId' => $id]);
        if ($delRes) {
            return response()->json([
                'code' => 1,
                'message' => '删除成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'message' => '删除失败'
            ]);
        }
    }

}