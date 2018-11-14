<?php

namespace App\Http\Middleware;
use App\Http\Models\Power;
use Closure;
use App\Http\Models\AdminRole;
use App\Http\Models\RolePower;
use Illuminate\Support\Facades\Redis;

class checkPower
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->session()->forget('activeId');
        $request->session()->forget('currentCheck');
        $currentUrl = $request->path();
        if(empty($request->session()->get('adminId')))
            return redirect('admin/login');
        $adminId = session()->get('adminId');
        if(!Redis::HGET('powerList',$adminId) || empty(Redis::HGET('powerList',$adminId)) || Redis::HEXISTS('powerList','powerChange')){
            Redis::DEL('powerList');
            $roleId = AdminRole::getOne(['adminId'=>$adminId]);
            $powerId = RolePower::getRolePowers(['roleId'=>$roleId]);
            $powerList = Power::getPowers($powerId)->toArray();
            Redis::HSET('powerList',$adminId,serialize($powerList));
            Redis::HDEL('powerList','powerChange');
        }
        $powerList = unserialize(Redis::HGET('powerList',$adminId));
        $menu = $this->getMenu($powerList,0);
        if($currentUrl=='admin/index'){
            $request->session()->put('menu',$menu);
            return $next($request);
        }
        $powerUrl = array_column($powerList,'powerUrl');
        $currentUrl = $request->path();
        $flag = false;
        foreach ($powerUrl as $k=>$v){
            if($v==$currentUrl){
                $flag = true;
                break;
            }
        }
        if($flag==false){
            return redirect('admin/index');
        }
        else{
            $request->session()->put('menu',$menu);
            $findRes = Power::getPower(['powerUrl'=>$currentUrl]);
            $request->session()->put('activeId',$findRes->parentId);
            $request->session()->put('currentCheck',$findRes->powerId);
            return $next($request);
        }
    }
    public function getMenu($powerList,$parentId=0){
        $menu = [];
        foreach ($powerList as $k=>$v) {
            if($powerList[$k]['parentId']==$parentId && $powerList[$k]['isShow']==1){
                $menu[$k] = $powerList[$k];
                $menu[$k]['child'] = $this->getMenu($powerList,$v['powerId']);
            }
        }
        return array_values($menu);
    }
}
