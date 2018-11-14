<?php
/**
 * 物流管理控制器
 *
 * @author story_line
 */
namespace App\Http\Controllers\Merchant;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Models\RxgUser;
use App\Http\Models\Logistics;
use Illuminate\Support\Facades\Validator;

class LogisticsController extends Controller
{
    /**
     * 物流列表展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function logisticsList()
    {
        $keyword = Request::get('keyword');
        $model = new Logistics();
        $sql = $model->where('name', 'like', '%'.$keyword.'%')->paginate(5);
        return view('merchant.logistics.logisticsList', ['data' => $sql, 'keyword' => $keyword]);
    }

    /**
     * 添加物流页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function logisticsAdd()
    {
        return view('merchant.logistics.logisticsAdd');
    }

    /**
     * 添加物流入库
     * @return \Illuminate\Http\JsonResponse
     */
    public function logisticsAdddo()
    {
        $data = Request::post();
        $rules = [
            'name' => 'required',
            'tel' => 'required',
        ];
        $message = [
            'Name.required' => '公司名称必填',
            'Tel.required' => '联系方式必填',
        ];
        $validate = Validator::make($data, $rules, $message);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            foreach ($errors as $k => $v) {
                return response()->json([
                    'code' => 2,
                    'message' => $errors[$k][0]
                ]);
            }
        }
        unset($data['_token']);
        $addRes = Logistics::insert($data);
        if ($addRes) {
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
	public function logisticsEdit()
	{
		if (Request::isMethod('post')) {
            $data = Request::post();
//          var_dump($data);die;
            $rules = [
                'name' => 'required',
                'tel' => 'required',
            ];
            $message = [
                'name.required' => '公司名称必填',
                'tel.required' => '联系方式必填',
            ];
            $validate = Validator::make($data, $rules, $message);
            if ($validate->fails()) {
                $errors = $validate->errors()->toArray();
                var_dump($errors);die;
                foreach ($errors as $k => $v) {
                    return response()->json([
                        'code' => 2,
                        'message' => $errors[$k][0]
                    ]);
                }
            }
            unset($data['_token']);
            $id = $data['id'];
            unset($data['id']);
            $updRes = Logistics::where('id', $id)->update($data);
            if ($updRes) {
                return response()->json([
                    'code' => 1,
                    'message' => '修改成功'
                ]);
            } else {
                return response()->json([
                    'code' => 2,
                    'message' => '修改失败'
                ]);
            }
        } else {
            $id = Request::get('id');
            $logisticsInfo = Logistics::getUser(['id' => $id]);
            $logisticsList = Logistics::getPs(['id' => 0]);
            return view('merchant.logistics.logisticsedit', [
                'logisticsList' => $logisticsList,
                'logisticsInfo' => $logisticsInfo
            ]);
        }
	}
}
