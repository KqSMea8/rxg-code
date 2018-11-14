<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;


class Goods extends Model
{
    public $timestamps = false;
    protected $table = 'goods';
    protected $primaryKey = 'goodsId';
    protected $fillable = ['goodsName', 'goodsDesc'];
    use Searchable;

    public function searchableAs() {
        return 'goods';
    }
    public function toSearchableArray()
    {
        return [
            'goodsName' => $this->goodsName,
            'goodsDesc' => $this->goodsDesc,
        ];
    }

    //添加商品
    public function addData($data)
    {
        return self::insert($data);
    }

    public function goodsShop($table,$data)
    {
        return DB::table($table)->insert($data);
    }

    public function goodsShow($shopId,$keyword,$catId)
    {   
    // var_dump($catId);die;
         return $this->leftjoin('goods_shop','goods_shop.goodsId','goods.goodsId')
                    ->join('goods_cats','goods_cats.catId','goods.catId')
                    ->where(['goods_shop.shopId'=>$shopId,'goods_shop.isSale'=>1])
                    ->where('goods.goodsName', "like", "%$keyword%")
                    ->where('goods_cats.catId', "like", "%$catId%")
                    ->paginate(10);
    }

    //分页
    public function getPage()
    {
        return self::paginate(4);
    }

    //查询所有商品
    public function getData()
    {
        return self::all()->toArray();
    }

    //删除商品
    public function delData($table,$id,$shopId)
    {
        return DB::table($table)->where(['goodsId' => $id,'shopId'=>$shopId])->delete();
    }

    //查询一条商品
    public function getOne($id)
    {
        return self::where(['goodsId' => $id])->first()->toArray();
    }

    //按多个id并模糊查询
    public function getMoreGoods($ids, $goodsName)
    {
        return self::where("goodsName", "like", "%$goodsName%")->whereIn('goodsId', $ids)->paginate(6);
    }

    //修改商品
    public function updateData($id, $data)
    {
        return self::where(['goodsId' => $id])->update($data);
    }

    //搜索带分页
//    public function search($where)
//    {
//        return self::where($where)->paginate(10);
//    }

    //批量删除
    public function piData($ids)
    {
        return self::whereIn("goodsId", $ids)->delete();
    }

    //查询此分类下的商品
    public function getGoodsList($catId)
    {
        return self::where('catId',$catId)->get()->toArray();
    }
    public static function getGoodsListByCatArr($catId){
        return self::whereIn('catId',$catId)->paginate(30);
    }
    /**
     * 获取前台商品
     * @author xiaowei.fan
     * @param int $num
     * @param bool $isGet
     * @return mixed
     */
    public static function getGoods($num = 24, $isGet = false)
    {
        $data = [];
        //获取活动商品
        if (empty(Redis::get('activeGoodsList')) || $isGet) {
            $activeGoodsList = Activity::where([
                ['sTime', '<', date('Y-m-d H:i:s')],
                ['oTime', '>', date('Y-m-d H:i:s')],
                ['isSale', 1]
            ])
                ->leftJoin('goods', 'activity.goodsId', 'goods.goodsId')
                ->leftJoin('shops', 'goods.shopId', 'shops.shopId')
                ->get()
                ->toArray();
            Redis::set('activeGoodsList', serialize($activeGoodsList));
        } else {
            $activeGoodsList = unserialize(Redis::get('activeGoodsList'));
        }
        $numReq = count($activeGoodsList) < $num ? count($activeGoodsList) : $num;
        $activeGoodsKey = array_rand($activeGoodsList, $numReq);
        $activeGoods = [];
        foreach ($activeGoodsList as $k => $v) {
            if (in_array($k, $activeGoodsKey)) {
                $activeGoods[] = $activeGoodsList[$k];
            }
        }
        $data['activeGoodsList'] = array_chunk($activeGoods, 6);
        //获取热销商品
        if (empty(Redis::zrange('hotGoodsList',0 , -1)) || $isGet) {
            $hotGoodsList = Goods::where([
                ['isSale', 1,],
                ['isHot', 1]
            ])
                ->leftJoin('shops', 'goods.shopId', 'shops.shopId')
                ->orderBy('saleNum', 'desc')
                ->limit($num)
                ->get()
                ->toArray();
            foreach ($hotGoodsList as $k => $v) {
                Redis::zadd('hotGoodsList', $v['saleNum'], serialize($v));
            }
        } else {
            $hotGoodsList = [];
            $hotGoods = Redis::zrange('hotGoodsList', 0, -1);
            for ($i = count($hotGoods)-1;$i>=0;$i--){
                $hotGoodsList[] = unserialize($hotGoods[$i]);
            }
        }
        $data['hotGoodsList'] = array_chunk($hotGoodsList, 6);
        //获取推荐商品
        if (empty(Redis::get('recomGoodsList')) || $isGet) {
            $recomGoodsList = Goods::where([
                ['isSale', 1],
                ['isHot', 1]
            ])
                ->leftJoin('shops', 'goods.shopId', 'shops.shopId')
                ->get()
                ->toArray();
            Redis::set('recomGoodsList', serialize($recomGoodsList));
        } else {
            $recomGoodsList = unserialize(Redis::get('recomGoodsList'));
        }
        $numReq = count($recomGoodsList) < $num ? count($recomGoodsList) : $num;
        $recomGoodsKey = array_rand($recomGoodsList, $numReq);
        $recomGoods = [];
        foreach ($recomGoodsList as $k => $v) {
            if (in_array($k, $recomGoodsKey)) {
                $recomGoods[] = $recomGoodsList[$k];
            }
        }
        $data['recomGoodsList'] = array_chunk($recomGoods, 6);
        return $data;
    }
    public static function getUserLove($num=24,$catId){
        $loveGoods = self::where('catId',$catId)->orderBy('saleNum','desc')->limit($num)->get()->toArray();
        $numReq = count($loveGoods) < $num ? count($loveGoods) : $num;
        $loveGoodsKey = array_rand($loveGoods, $numReq);
        $loveGoodsList = [];
        if(!empty($loveGoodsList)){
            foreach ($loveGoods as $k => $v) {
                if (in_array($k, $loveGoodsKey)) {
                    $loveGoodsList[] = $loveGoods[$k];
                }
            }
        }
        return array_chunk($loveGoodsList, 6);
    }
}