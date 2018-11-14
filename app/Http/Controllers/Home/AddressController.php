<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Models\Area;
use App\Http\Models\Site;
use App\Http\Models\User;
use App\Http\Models\Address;
use App\Http\Models\RxgUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use App\Http\Models\Goods_cats;
class AddressController extends Controller
{
    //地址添加页
        public function addressAdd()
    {
        $userId = session()->get('userId');
        $area=new Area();
        $provinceAll=$area->province();
        $addre = new Address();
        $allAddre = $addre -> allAddre();
        $model = new Site();
        $data = $model ->select('rxg_address');
        $catList = Goods_cats::getCatList();
        if(!$allAddre->isEmpty())
        {
            //查询出地址表中省市区所对应的名称
            foreach ($allAddre as $k=>$v){
                $v->provinceName = $area->provinceOne($v->province)->areaName;
                $v->cityName = $area->cityOne($v->city)->areaName;
                $v->distructName = $area->distructOne($v->distruct)->areaName;

        }
            //查出用户表中的地址ID并且设为默认地址
            $user=new User();
            $addressId=$user->addressId();
            $model = new RxgUser();
            $user = $model -> select('rxg_user',$userId);
            return view("home.address.addressAdd",[
                'data'=>$data,
                "area"=>$provinceAll,
                "address"=>$allAddre,
                "address_id"=>$addressId,
                "user"=>$user,
                'catList'=>$catList
            ]);
             }
         
         else{
            $model = new RxgUser();
            $user = $model -> select('rxg_user',$userId);
            return view("home.address.addressAdd",[
                'data'=>$data,
                "area"=>$provinceAll,
                "address"=>$allAddre,
                "user"=>$user,
                'catList'=>$catList
            ]);
        }
    }
    public function addressDo()
    {
        $data = Request::post();
        $rules = [
            'province' => 'required',
            'city' => 'required',
            'distruct' => 'required',
            'street' => 'required',
            'email' => 'required',
            'user_name' => 'required',
            'tell' => 'required',
        ];
        $message = [
            'province.required'=>'省必须选',
            'city.required'=>'城市必选',
            'distruct.required'=>'县城必选',
            'street.required' => '详细地址必填',
            'email.required' => '邮政编码必填',
            'user_name.required' => '收货人姓名必填',
            'tell.required' => '手机号码必填',
        ];
        $validate = Validator::make($data, $rules,$message);
        if ($validate->fails()){
            $errors = $validate->errors()->toArray();
            foreach ($errors as $k=>$v){
                return response()->json([
                    'code'=>2,
                    'message'=>$errors[$k][0]
                ]);
            }
        }
        unset($data['_token']);
        $model = new Site;
        $res = $model->insertData($data);
        if ($res) {
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
    //地址修改页
    public function addressUp()
    {
        return view('home.address.addressUp');
    }
    //三级联动查看市
    public function city()
    {
        $id = Request::get('id');
        $model = new Area();
        $data = $model -> orderCity($id);
        return response()->json([
                'code'=>1,
                'data'=>$data
            ]);
    }
    //三级联动县
    public function distruct()
    {
        $id = Request::get('value');
        $model = new Area();
        $data = $model -> orderCity($id);

        return response()->json([
                'code'=>1,
                'data'=>$data
            ]);
    }
    //地址删除
    public function addressDel()
    {
        $id = Request::get('id');
        $delRes = Site::addressDel(['id'=>$id]);
        if ($delRes) {
            return response() -> json([
                    'code' =>1,
                    'message' =>'删除成功'
                ]);
        }else{
            return response() -> json([
                    'code' =>2,
                    'message' =>'删除失败'
                ]);
        }
    }
    public function up()
    {
        $userId = session()->get('userId');
        $id = Request::get('id');
        $area=new Area();
        $provinceAll=$area->province();
        $model = new Site();
        $data = $model ->select('rxg_address');
        $info = $model->where('id',$id)->first()->toArray();
        $catList = Goods_cats::getCatList();
        $addre = new Address();
        $allAddre = $addre -> allAddre();
       if(!$allAddre->isEmpty())
        {
            //查询出地址表中省市区所对应的名称
            foreach ($allAddre as $k=>$v){
                $v->provinceName = $area->provinceOne($v->province)->areaName;
                $v->cityName = $area->cityOne($v->city)->areaName;
                $v->distructName = $area->distructOne($v->distruct)->areaName;

        }
            //查出用户表中的地址ID并且设为默认地址
            $user=new User();
            $addressId=$user->addressId();
            $model = new RxgUser();
            $user = $model -> select('rxg_user',$userId);
            return view("home.address.addressUp",[
                'data'=>$data,
                "area"=>$provinceAll,
                "address"=>$allAddre,
                "address_id"=>$addressId,
                "user"=>$user,
                "info"=>$info,
                'catList'=>$catList
            ]);
             }
         
         else{
            $model = new RxgUser();
            $user = $model -> select('rxg_user',$userId);
            return view("home.address.addressUp",[
                'data'=>$data,
                "area"=>$provinceAll,
                "address"=>$allAddre,
                "user"=>$user,
                "info" =>$info,
                'catList'=>$catList
            ]);
        }
    }
    public function addressUpdate()
    {
        $data = Request::all();
        unset($data['_token']);
        $id = $data['id'];
        $model = new Site;
        $sql = $model ->upd($id,$data);
        if ($sql) {
          return redirect('address/addressAdd');
        } else {
            dd('修改失败');
        }
    }
    //修改用户表中的address_id
    public function addressUpdateId()
    {
        if (Request::ajax()) {

            $address_id = Request::post("address_id");
            $user = new User();
            $address = $user -> userAddress($address_id);
            return response() -> json([
                    'code' => 1,
                    'message' => '修改成功'
                ]);
        }
    }
}

