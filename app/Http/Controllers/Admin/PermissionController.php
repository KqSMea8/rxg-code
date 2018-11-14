<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Power;
use App\Http\Models\RolePower;
use App\Http\Models\Role;
use App\Http\Models\Admin;
use App\Http\Models\AdminRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

class PermissionController extends Controller
{
    public function menu()
    {
        $keyword = Request::get('keyword', '');
        $where = [];
        $where[] = ['powerName', 'like', '%' . $keyword . '%'];
        $powerList = Power::getPsO($where);
        $powerList->appends(['keyword' => $keyword]);
        return view('admin.permission.menu', [
            'powerList' => $powerList,
            'keyword' => $keyword
        ]);
    }

    public function powerAdd()
    {
        $isShow = ['不展示', '展示'];
        $status = ['不启用', '启用'];
        $powerList = Power::getPs(['parentId' => 0, 'status' => 1]);
        return view('admin.permission.power_add', [
            'powerList' => $powerList,
            'isShow' => $isShow,
            'status' => $status
        ]);
    }

    public function powerAddDo()
    {
        $data = Request::post();
        $rules = [
            'powerName' => 'required',
            'parentId' => 'required',
            'powerUrl' => 'required',
        ];
        $message = [
            'powerName.required' => '权限名称必填',
            'parentId.required' => '上级权限必填',
            'powerUrl.required' => '权限URL必填',
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
        if (Power::where('powerName', $data['powerName'])->first()) {
            return response()->json([
                'code' => 2,
                'message' => '该权限名称已存在'
            ]);
        }
        unset($data['_token']);
        if ($data['parentId'] == 0) {
            $powerId = Power::insertGetId($data);
            $addRes = Power::where('powerId', $powerId)->update(['path' => $powerId]);
        } else {
            $data['path'] = $data['parentId'];
            $addRes = Power::powerAdd($data);
        }
        if ($addRes) {
            Redis::HSET('powerList', 'powerChange', 1);
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

    public function powerEdit()
    {
        if (Request::isMethod('post')) {
            $data = Request::post();
            $rules = [
                'powerName' => 'required',
                'parentId' => 'required',
                'powerUrl' => 'required',
            ];
            $message = [
                'powerName.required' => '权限名称必填',
                'parentId.required' => '上级权限必填',
                'powerUrl.required' => '权限URL必填',
            ];
            if ($data['parentId'] == 0) {
                $data['path'] = $data['powerId'];
            } else {
                $data['path'] = $data['parentId'];
            }
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
            $powerId = $data['powerId'];
            unset($data['powerId']);
            $updRes = Power::where('powerId', $powerId)->update($data);
            if ($updRes) {
                Redis::HSET('powerList', 'powerChange', 1);
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
            $powerId = Request::get('powerId');
            $powerInfo = Power::getPower(['powerId' => $powerId]);
            $isShow = ['不展示', '展示'];
            $status = ['不启用', '启用'];
            $powerList = Power::getPs(['parentId' => 0, 'status' => 1]);
            return view('admin.permission.power_edit', [
                'powerList' => $powerList,
                'isShow' => $isShow,
                'status' => $status,
                'powerInfo' => $powerInfo
            ]);
        }
    }

    public function powerDel()
    {
        $powerId = Request::get('powerId');
        $childNum = Power::where('parentId', $powerId)->count();
        if ($childNum) {
            return response()->json([
                'code' => 2,
                'message' => '删除失败（该权限下还有子权限）'
            ]);
        }
        $delRes = Power::powerDel(['powerId' => $powerId]);
        Redis::HSET('powerList', 'powerChange', 1);
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

    public function givePower()
    {
        if (Request::isMethod('post')) {
            $roleId = Request::post('roleId');
            $addPowerId = Request::post('addPowerId');
            $delPowerId = Request::post('delPowerId');
            if (!empty($addPowerId)) {
                foreach ($addPowerId as $k => $v) {
                    $data = [
                        'roleId' => $roleId,
                        'powerId' => $v
                    ];
                    $findRes = RolePower::getOne($data);
                    if (!$findRes) {
                        RolePower::insertOne($data);
                    }
                }
            }
            if (!empty($delPowerId)) {
                foreach ($delPowerId as $k => $v) {
                    $data = [
                        'roleId' => $roleId,
                        'powerId' => $v
                    ];
                    $findRes = RolePower::getOne($data);
                    if ($findRes) {
                        $findRes->delete();
                    }
                }
            }
            Redis::HSET('powerList', 'powerChange', 1);
            return response()->json([
                'code' => 1,
                'message' => '操作成功'
            ]);
        }
        $roleList = Role::getRoles(['status' => 1]);
        $powerList = Power::getPs(['status' => 1, 'parentId' => 0]);
        $rolePower = [];
        foreach ($roleList as $k => $v) {
            $rolePower[$v->roleId] = RolePower::getRolePowers(['roleId' => $v->roleId])->toArray();
        }
        foreach ($powerList as $k => $v) {
            $powerList[$k]['child'] = Power::getPs(['status' => 1, 'parentId' => $v->powerId]);
        }
        return view('admin.permission.give_power', [
            'roleList' => $roleList,
            'powerList' => $powerList,
            'rolePower' => $rolePower
        ]);
    }

    public function roleList()
    {
        $roleList = Role::getRoles();
        return view('admin.permission.role_list', ['roleList' => $roleList]);
    }

    public function roleAdd()
    {
        if (Request::isMethod('post')) {
            $postData = Request::post();
            $rules = [
                'roleName' => 'required',
                'status' => 'required'
            ];
            $message = [
                'roleName.required' => '角色名称必填',
                'status.required' => '角色状态必填'
            ];
            $validate = Validator::make($postData, $rules, $message);
            if ($validate->fails()) {
                $errors = $validate->errors()->toArray();
                foreach ($errors as $k => $v) {
                    return response()->json([
                        'code' => 2,
                        'message' => $errors[$k][0]
                    ]);
                }
            }
            unset($postData['_token']);
            $findRes = Role::checkRoleName($postData['roleName']);
            if ($findRes) {
                return response()->json([
                    'code' => 2,
                    'message' => '该角色名称已存在'
                ]);
            }
            $addRes = Role::roleAdd($postData);
            if ($addRes) {
                Redis::HSET('powerList', 'powerChange', 1);
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
        } else {
            $status = ['不启用', '启用'];
            return view('admin.permission.role_add', ['status' => $status]);
        }
    }

    public function roleDel()
    {
        $roleId = Request::get('roleId');
        $delRes = Role::roleDel(['roleId' => $roleId]);
        Redis::HSET('powerList', 'powerChange', 1);
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

    public function roleEdit()
    {
        if (Request::isMethod('post')) {
            $data = Request::post();
            $rules = [
                'roleName' => 'required',
            ];
            $message = [
                'roleName.required' => '角色名称必填',
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
            $roleId = $data['roleId'];
            unset($data['roleId']);
            $updRes = Role::where('roleId', $roleId)->update($data);
            if ($updRes !== false) {
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
            $roleId = Request::get('roleId');
            $roleInfo = Role::where('roleId', $roleId)->first();
            $status = ['不启用', '启用'];
            return view('admin.permission.role_edit', [
                'roleInfo' => $roleInfo,
                'status' => $status
            ]);
        }
    }

    public function person()
    {
        $keyword = Request::get('keyword', '');
        $status = Request::get('status', 2);
        $statusArr = [2 => '--状态--', 0 => '未启用', 1 => '启用'];
        $where = [];
        if ($status != 2) {
            $where[] = ['admin.status', $status];
        }
        $where[] = ['adminName', 'like', '%' . $keyword . '%'];
        $adminList = Admin::getAdmins($where);
        $adminList->appends(['keyword' => $keyword, 'status' => $status]);
        return view('admin.permission.person', [
            'adminList' => $adminList,
            'keyword' => $keyword,
            'status' => $status,
            'statusArr' => $statusArr,
        ]);
    }

    public function personAdd()
    {
        if (Request::isMethod('post')) {
            $postData = Request::post();
            $rules = [
                'adminName' => 'required',
                'roleId' => 'required',
                'password' => 'required',
            ];
            $message = [
                'adminName.required' => '管理员名称必填',
                'roleId.required' => '所属角色必选',
                'password.required' => '密码必填',
            ];
            $validate = Validator::make($postData, $rules, $message);
            if ($validate->fails()) {
                $errors = $validate->errors()->toArray();
                foreach ($errors as $k => $v) {
                    return response()->json([
                        'code' => 2,
                        'message' => $errors[$k][0]
                    ]);
                }
            }
            $findRes = Admin::getAdmin(['adminName' => $postData['adminName']]);
            if ($findRes) {
                return response()->json([
                    'code' => 2,
                    'message' => '管理员名称已存在'
                ]);
            }
            unset($postData['_token']);
            DB::beginTransaction();
            try {
                $adminId = Admin::insertGetId([
                    'adminName' => $postData['adminName'],
                    'password' => $postData['password'],
                    'status' => $postData['status']
                ]);
                AdminRole::insert([
                    'adminId' => $adminId,
                    'roleId' => $postData['roleId']
                ]);
                DB::commit();
                return response()->json([
                    'code' => 1,
                    'message' => '添加成功'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 2,
                    'message' => '添加失败'
                ]);
            }
        } else {
            $status = ['不启用', '启用'];
            $roleList = Role::getRoles(['status' => 1]);
            return view('admin.permission.person_add', [
                'status' => $status,
                'roleList' => $roleList
            ]);
        }
    }

    public function personDel()
    {
        $adminId = Request::get('adminId');
        DB::beginTransaction();
        try {
            Admin::adminDel(['adminId' => $adminId]);
            AdminRole::delData(['adminId' => $adminId]);
            DB::commit();
            return response()->json([
                'code' => 1,
                'message' => '删除成功'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 2,
                'message' => '删除失败'
            ]);
        }
    }

    public function personEdit()
    {
        if (Request::isMethod('post')) {
            $data = Request::post();
            $rules = [
                'adminName' => 'required',
                'roleId' => 'required',
                'password' => 'required',
            ];
            $message = [
                'adminName.required' => '管理员名称必填',
                'roleId.required' => '管理员所属角色必填',
                'password.required' => '管理员登录密码必填',
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
            $adminId = $data['adminId'];
            $roleId = $data['roleId'];
            unset($data['adminId']);
            unset($data['roleId']);
            $updRes = Admin::where('adminId', $adminId)->update($data);
            AdminRole::where('adminId', $adminId)->update(['roleId' => $roleId]);
            if ($updRes !== false) {
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
            $adminId = Request::get('adminId');
            $status = ['不启用', '启用'];
            $adminInfo = Admin::join('admin_role', 'admin.adminId', 'admin_role.adminId')
                ->join('role', 'admin_role.roleId', 'role.roleId')
                ->where('admin.adminId', $adminId)
                ->first();
            $roleList = Role::getRoles(['status' => 1]);
            return view('admin.permission.person_edit', [
                'status' => $status,
                'roleList' => $roleList,
                'adminInfo' => $adminInfo
            ]);
        }

    }
}