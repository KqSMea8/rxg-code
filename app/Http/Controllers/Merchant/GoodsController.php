<?php
/**
 * 商品控制器
 *
 * @author story_line
 */
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Models\Brand;
use App\Http\Models\Goods;
use App\Http\Models\ShopGoods;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Goods_cats;

class GoodsController extends Controller
{
    /**
     * 商品展示列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function goodsList()
    {
        $keyword = Request::get('keyword', '');
        $catId = Request::get('catId', '');
        $goods = new Goods;
        if (!empty($keyword)) {
            $goods = $goods->where('goodsName', "like", "%$keyword%");
        }
        if (!empty($catId)) {
            $catIdArr = $this->getCatList()[$catId];
            $goods = $goods->whereIn('catId', $catIdArr);
        }
        $goods_cats = new Goods_cats;
        $goodscats = $goods_cats->getParent();
        $shop_goods = new ShopGoods();
        $goods_id = $shop_goods->where('shop_id', session()->get('shopId'))->value('goods_id');
        $goods_id = explode(',', $goods_id);
        $data = $goods->WhereIn('goodsId', $goods_id)->paginate(10);
        $data->appends([
            'keyword' => $keyword,
            'catId' => $catId
        ]);

        return view('merchant.goods.goods_list', [
            'data' => $data,
            'goodscats' => $goodscats,
            'catId' => $catId,
            'keyword' => $keyword
        ]);
    }

    /**
     * 返回分类数据
     * @return array
     */
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

    /**
     * 商品上架展示列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function goodsAdd()
    {
        $keyword = Request::get('keyword', '');
        $catId = Request::get('catId', '');
        $goods = new Goods;
        if (!empty($keyword)) {
            $goods = $goods->where('goodsName', "like", "%$keyword%");
        }
        if (!empty($catId)) {
            $catIdArr = $this->getCatList()[$catId];
            $goods = $goods->whereIn('catId', $catIdArr);
        }
        $goods_cats = new Goods_cats;
        $goodscats = $goods_cats->getParent();
        $shop_goods = new ShopGoods();
        $goods_id = $shop_goods->where('shop_id', session()->get('shopId'))->value('goods_id');
        $goods_id = explode(',', $goods_id);
        $data = $goods->whereNotIn("goodsId", $goods_id)->paginate(10);
        $data->appends([
            'keyword' => $keyword,
            'catId' => $catId
        ]);
        return view('merchant.goods.goods_add', [
            'data' => $data,
            'goodscats' => $goodscats,
            'catId' => $catId,
            'keyword' => $keyword
        ]);
    }

    /**
     * 商品上架
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsAddDo()
    {
        $id = Request::all('id');
        if (is_array($id['id'])) {
            $id = implode(',', $id['id']);
        }
        $data['shop_id'] = session()->get('shopId');
        $data['goods_id'] = $id;
        $shop_goods = new ShopGoods();
        $res = $shop_goods->where('shop_id', session()->get('shopId'))->value('goods_id');
        if ($res == null) {
            $result = $shop_goods->insert($data);
        } else {
            if (!is_array($id)) {
                $data['goods_id'] = $res.','.$id;
            } else {
                $data['goods_id'] = $res.','.$id['id'];
            }
            $result = $shop_goods->where('shop_id', session()->get('shopId'))->update(['goods_id' => $data['goods_id']]);
        }
        if ($result) {
            return response()->json([
                'code' => 1,
                'msg' => '上架成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'msg' => '上架失败'
            ]);
        }
    }

    /**
     * 商品下架
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsDel()
    {
        $id = Request::get('id');
        $shop_goods = new ShopGoods();
        $goods_id = $shop_goods->where('shop_id', session()->get('shopId'))->value('goods_id');
        $goods_id = explode(',', $goods_id);
        if (is_array($id)) {
            foreach ($goods_id as $item => $val) {
                if (in_array($val, $id)) {
                    unset($goods_id[$item]);
                }
            }
        } else {
            foreach ($goods_id as $key => $value) {
                if ($id == $value) {
                    unset($goods_id[$key]);
                }
            }
        }
        $goods_id = implode(',', $goods_id);
        $res = $shop_goods->where('shop_id', session()->get('shopId'))->update(['goods_id' =>$goods_id]);
        if ($res) {
            return response()->json([
                'code' => 1,
                'msg' => '下架成功'
            ]);
        } else {
            return response()->json([
                'code' => 0,
                'msg' => '下架失败'
            ]);
        }
    }


}