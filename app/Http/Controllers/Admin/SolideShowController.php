<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\SolideShow;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SolideShowController extends Controller
{
    public function solideShowList()
    {
        $solide_show = new SolideShow();
        $data = $solide_show->orderByraw('id desc')->paginate(10);
        return view('admin.solideshow.solideshow_list', ['data' => $data]);
    }

    public function solideShowAdd()
    {
        return view('admin.solideshow.solideshow_add');
    }

    public function solideShowAddDo()
    {
        $data = Request::post();
        $data['img_path'] = Request::file('img_path');
        $rules = [
            'img_name' => 'required',
            'img_url' => 'required',
            'is_show' => 'required',
            'img_path' => 'required'
        ];
        $message = [
            'img_name.required' => '轮播图名称必填',
            'img_url.required' => '轮播图URL必填',
            'is_show.required' => '是否启用为必选',
            'img_path.required' => '请选择图片'
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
        $ext = $data['img_path']->getClientOriginalExtension();
        $realPath = $data['img_path']->getRealPath();
        $filename = date("Y-m-d-H-i-s").'-'.uniqid().'.'.$ext;
        $bool = Storage::disk('uploads/solideshow')->put($filename, file_get_contents($realPath));
        $data['img_path'] = 'uploads/solideshow/'.$filename;
        unset($data['_token']);
        $solide_show = new SolideShow();
        $res = $solide_show->insert($data);
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

    public function solideShowChange()
    {
        $id = Request::get('id');
        $is_show = Request::get('is_show');
        $res = (new SolideShow())->where(['id' => $id])->update(['is_show' => $is_show]);
        if ($res) {
            return response()->json(['code' => 1, 'msg' => '修改成功']);
        } else {
            return response()->json(['code' => 0, 'msg' => '修改失败']);
        }
    }

    public function solideShowDel()
    {
        $id = Request::get('id');
        $res = (new SolideShow())->where(['id' => $id])->delete();
        if ($res) {
            return response()->json(['code' => 1, 'msg' => '删除成功']);
        } else {
            return response()->json(['code' => 0, 'msg' => '删除失败']);
        }
    }

    public function update()
    {
        $id = Request::get('id');
        $solide = new SolideShow();
        $data = $solide->where(['id' => $id])->first();

        return view('admin.solideshow.update', ['data' => $data]);
    }

    public function updateDo()
    {
        $data = Request::post();
        $data['img_path'] = Request::file('img_path');
        $rules = [
            'img_name' => 'required',
            'img_url' => 'required',
            'is_show' => 'required',
        ];
        $message = [
            'img_name.required' => '轮播图名称必填',
            'img_url.required' => '轮播图URL必填',
            'is_show.required' => '是否启用为必选',
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
        if ($data['img_path']) {
            $ext = $data['img_path']->getClientOriginalExtension();
            $realPath = $data['img_path']->getRealPath();
            $filename = date("Y-m-d-H-i-s").'-'.uniqid().'.'.$ext;
            $bool = Storage::disk('uploads/solideshow')->put($filename, file_get_contents($realPath));
            $data['img_path'] = 'uploads/solideshow/'.$filename;
        }else{
            unset($data['img_path']);
        }
        unset($data['_token']);
        $solide_show = new SolideShow();
        $res = $solide_show->where(['id' => $data['id']])->update($data);
        if ($res == 0 || $res) {
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
    }
}