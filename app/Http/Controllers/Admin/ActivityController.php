<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Activity;
use App\Http\Models\Goods;
use App\Http\Models\Goods_cats;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Models\ActivityDrink;
use Illuminate\Support\Facades\Redis;

class ActivityController extends Controller
{
    //活动展示页
    public function activityList()
    {
        $keyword = Request::get('keyword', '');
        $where = [];
        $where[] = ['activityName', 'like', '%' . $keyword . '%'];
        $model = new Activity;
        $data = $model->selects($where);
        $data->appends(['keyword' => $keyword]);
        return view('admin.activity.activityList', ['data' => $data], ['keyword' => $keyword]);
    }

    public function activityDrink()
    {
        $id = Request::get("id");
        $model = new ActivityDrink();
        $data = $model->drink($id);
        var_dump($data);


    }

    //活动添加页
    public function activityAdd()
    {

        $model = new Activity;
        $cat = $model->catSelect();
        $catList = $this->getCatList();
        $goods = [];
        foreach ($catList as $k => $v) {
            $goods[$k] = Goods::whereIn('catId', $v)->get()->toArray();
        }
        return view('admin.activity.activityAdd', ["cat" => $cat], ["goods" => $goods]);
    }

    public function getCatList()
    {
        $catId = [];
        $catList = Goods_cats::where('parentId', 0)->get()->pluck('catId')->toArray();
        foreach ($catList as $k => $v) {
            $catId[$v][] = $v;
            foreach (Goods_cats::where('parentId', $v)->get()->pluck('catId')->toArray() as $key => $val) {
                $catId[$v][] = $val;
                foreach (Goods_cats::where('parentId', $val)->get()->pluck('catId')->toArray() as $keys => $vals) {
                    $catId[$v][] = $vals;
                }
            }
        }
        return $catId;
    }

    public function AddDo()
    {
        $data = Request::post();
        $time = $data['time'];
        $data['sTime'] = explode(' - ', $time)[0];
        $data['oTime'] = explode(' - ', $time)[1];
        unset($data['time']);
        unset($data['catId']);
        $rules = [
            'activityName' => 'required',
            'goodsId' => 'required',
            'sTime' => 'required',
            'oTime' => 'required',
            'activityDesc' => 'required',
            'activityClass' => 'required',
            'favourable' => 'required',
        ];
        $message = [
            'activityName.required' => '活动名称名称必填',
            'goodsId.required' => '活动商品必填',
            'sTime.required' => '活动开始时间必填',
            'oTime.required' => '活动结束时间必填',
            'activityDesc.required' => '活动描述必填',
            'activityClass.required' => '活动类型必选',
            'favourable.required' => '优惠价填',
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
        $model = new Activity;
        $res = $model->insertData($data);
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


    //活动删除
    public function activityDel()
    {
        $id = Request::get('id');
        $delRes = Activity::activityDel(['id' => $id]);
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

    //活动修改
    public function up()
    {
        $id = Request::get('id');
        $model = new Activity;
        $cat = $model->catSelect();
        $catList = $this->getCatList();
        $goods = [];
        $info = $model->leftJoin('goods', 'activity.goodsId', 'goods.goodsId')->where('id', $id)->first()->toArray();
        foreach ($catList as $k => $v) {
            $goods[$k] = Goods::whereIn('catId', $v)->get()->toArray();
            foreach ($v as $key => $value) {
                if ($info['catId'] == $value) {
                    $info['catId'] = $k;
                }
            }
        }
        return view('admin.activity.activityUp', [
            "activity" => $info,
            "catList" => $catList,
            "cat" => $cat,
            'goods' => $goods
        ]);
    }

    public function activityUpdate()
    {
        $data = Request::all();
        unset($data['_token']);
        unset($data['catId']);
        $time = $data['time'];
        $data['sTime'] = explode(' - ', $time)[0];
        $data['oTime'] = explode(' - ', $time)[1];
        unset($data['time']);
        $id = $data['id'];
        $model = new Activity;
        $sql = $model->upd($id, $data);
        if ($sql) {
            return redirect('admin/activity/activityList');
        } else {
            dd('修改失败');
        }

    }
}
