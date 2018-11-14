<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\RxgShops;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function storeList()
    {
        $store = new RxgShops();
        $isSelf = Request::get('isSelf',2);
        $shopStatus = Request::get('shopStatus',2);
        $isVerify = Request::get('isVerify',3);
        $keyword = Request::get('keyword','');
        $where = [];
        if($isSelf!=2){
            $where[] = ['isSelf',$isSelf];
        }
        if($shopStatus!=2){
            $where[] = ['shopStatus',$shopStatus];
        }
        if($isVerify!=3){
            $where[] = ['isVerify',$isVerify];
        }
        $where[] = ['shopName','like','%'.$keyword.'%'];
        $data = $store->leftJoin('user','shops.userId','user.userId')->where($where)->select('shops.*','user.userName')->paginate(8);
        $data->appends([
            'isSelf'=>$isSelf,
            'shopStatus'=>$shopStatus,
            'shopName'=>$keyword,
            'isVerify'=>$isVerify
        ]);
        $isSelfArr = [2=>'--是否自营--',0=>'非自营',1=>'自营'];
        $shopStatusArr = [2=>'--店铺状态--',0=>'异常',1=>'正常'];
        $isVerifyArr = ['未审核','通过','未通过'];
        return view('admin.store.store_list', [
            'data' => $data,
            'isSelfArr'=>$isSelfArr,
            'shopStatusArr'=>$shopStatusArr,
            'isSelf'=>$isSelf,
            'shopStatus'=>$shopStatus,
            'shopName'=>$keyword,
            'isVerifyArr'=>$isVerifyArr,
            'isVerify'=>$isVerify
        ]);
    }
    public function storeEdit(){
        if(Request::isMethod('post')){
            $data = Request::post();
            $rules = [
                'shopName' => 'required',
            ];
            $message = [
                'shopName.required'=>'店铺名称必填',
            ];
            $validate = Validator::make($data, $rules,$message);
            if($validate->fails()){
                $errors = $validate->errors()->toArray();
                foreach ($errors as $k=>$v){
                    return response()->json([
                        'code'=>2,
                        'message'=>$errors[$k][0]
                    ]);
                }
            }
            unset($data['_token']);
            $shopId = $data['shopId'];
            unset($data['shopId']);
            $updRes = RxgShops::where('shopId',$shopId)->update($data);
            if($updRes){
                return response()->json([
                    'code'=>1,
                    'message'=>'修改成功'
                ]);
            }else{
                return response()->json([
                    'code'=>2,
                    'message'=>'修改失败'
                ]);
            }
        }else{
            $shopId = Request::get('shopId');
            $findRes = RxgShops::leftJoin('user','shops.userId','user.userId')->select('shops.*','user.userName')->where('shopId',$shopId)->first();
            $isSelf = [0=>'非自营',1=>'自营'];
            $shopStatus = [0=>'异常',1=>'正常'];
            return view('admin.store.store_edit',[
                'shopInfo'=>$findRes,
                'isSelf'=>$isSelf,
                'shopStatus'=>$shopStatus,
            ]);
        }
    }
    public function merchantEntryAudit()
    {
        $store = new RxgShops();
        $data = $store->leftJoin('user','shops.userId','user.userId')->paginate(10);
        $isVerifyArr = ['未审核','通过','未通过'];
        return view('admin.store.merchant_entry_audit',[
            'data'=>$data,
            'isVerifyArr'=>$isVerifyArr
        ]);
    }
    public function updateVerify(){
        $store = new RxgShops();
        $shopId = Request::get('shopId');
        $isVerify = Request::get('isVerify');
        $updateRes = $store->where('shopId',$shopId)->update(['isVerify'=>$isVerify]);
        if ($updateRes)
            return response()->json([
                'code'=>1,
                'message'=>'操作成功'
            ]);
        else
            return response()->json([
                'code'=>2,
                'message'=>'操作失败'
            ]);
    }
}