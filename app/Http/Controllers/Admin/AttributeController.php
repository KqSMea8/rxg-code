<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Attributes;
use App\Http\Models\AttributesValue;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Brand;
use App\Http\Models\Advertising;
use App\Http\Models\Goods_cats;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
class AttributeController extends Controller
{
//属性列表
	public function attrList()
	{
	    $attrName = Request::get('attrName','');
		$attrList = Attributes::getAttrList($attrName);
        foreach ($attrList as $k=>$v) {
            $attrList[$k]['attrValue'] = AttributesValue::getAttrValue($v['attrId']);
		}
		return view('admin.attribute.attr_list',[
		    'attrList'=>$attrList,
		    'attrName'=>$attrName,
        ]);
	}
//属性修改
	public function attrEdit()
	{
		if(Request::isMethod('post')){
		    $data = Request::post();
            $avNameArr = $data['avName'];
            unset($data['_token']);
            unset($data['avName']);
		    $attrId = $data['attrId'];
		    unset($data['attrId']);
            DB::beginTransaction();
            try{
                AttributesValue::delAttrValue($attrId);
                Attributes::attrUpdate([
                    'attrId'=>$attrId
                ],$data);
                foreach ($avNameArr as $k=>$v) {
                    AttributesValue::insert([
                        'avName'=>$v,
                        'aid'=>$attrId
                    ]);
                }
                DB::commit();
                return response()->json([
                    'code'=>1,
                    'message'=>'修改成功'
                ]);
            }catch (QueryException $e){
                DB::rollback();
                return response()->json([
                    'code'=>2,
                    'message'=>'修改失败'
                ]);
            }
        }else{
            $attrId = Request::get('attrId');
            $attrInfo = Attributes::getOne([
                'attrId'=>$attrId
            ])->toArray();
            $attrValue = AttributesValue::getAttrValue($attrId)->toArray();
            $goodsCatsModel = new Goods_cats();
            $catList = $goodsCatsModel->get()->toArray();
            $parentId3 = $goodsCatsModel->getOne($attrInfo['goodsCatId']);
            $catList3 = $goodsCatsModel->getSons($parentId3['parentId'])->toArray();
            $parentId2 = $goodsCatsModel->getOne($catList3[0]['parentId']);
            $catList2 = $goodsCatsModel->getSons($parentId2['parentId'])->toArray();
            $parentId1 = $goodsCatsModel->getOne($catList2[0]['parentId']);
            $catList1 = $goodsCatsModel->getSons($parentId1['parentId'])->toArray();
            return view('admin.attribute.attr_edit',[
                'attrInfo'=>$attrInfo,
                'catList' => $catList,
                'parentId1'=>$parentId1,
                'parentId2'=>$parentId2,
                'parentId3'=>$parentId3,
                'catList1'=>$catList1,
                'catList2'=>$catList2,
                'catList3'=>$catList3,
                'attrValue'=>$attrValue,
            ]);
        }
	}
    //添加属性
    public function attrAdd()
    {
        if(Request::isMethod('POST')){
            $data = Request::post();
            $avNameArr = $data['avName'];
            unset($data['_token']);
            unset($data['avName']);
            $findRes = Attributes::getOne([
                'attrName'=>$data['attrName'],
                'goodsCatId'=>$data['goodsCatId']
            ]);
            if($findRes){
                return response()->json([
                    'code'=>2,
                    'message'=>'属性名称重复'
                ]);
            }
            DB::beginTransaction();
            try{
                $data['addTime'] = date('Y-m-d H:i:s');
                $aid = Attributes::insertGetId($data);
                foreach ($avNameArr as $k=>$v) {
                    AttributesValue::insert([
                        'avName'=>$v,
                        'aid'=>$aid
                    ]);
                }
                DB::commit();
                return response()->json([
                    'code'=>1,
                    'message'=>'添加成功'
                ]);
            }catch (QueryException $e){
                DB::rollback();
                return response()->json([
                    'code'=>2,
                    'message'=>'添加失败'
                ]);
            }
        }else{
            $goods_cats = new Goods_cats;
            $parentCat = $goods_cats->getCatList();
            $goodsCats = $goods_cats->get()->toArray();
            return view('admin.attribute.attrAdd', [
                'goodscats' => $goodsCats,
                'parentCat'=>$parentCat
            ]);
        }
    }
    //属性删除
    public function attrDel()
    {
        $attrId = Request::get('attrId');
        $delRes = Attributes::attrDel([
            'attrId'=>$attrId
        ]);
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