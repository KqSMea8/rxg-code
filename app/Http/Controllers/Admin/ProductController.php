<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Request;

use App\Http\Models\Shops;

use App\Http\Models\Brand;

use App\Http\Models\Goods;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

use Illuminate\Pagination\Paginator;

use App\Http\Rules\Checkmobile;

use App\Http\Models\Goods_cats;

use App\Http\Models\Attributes;

use App\Http\Models\AttributesValue;

use App\Http\Models\GoodsSku;

class ProductController extends Controller
{
    //后台添加SKU
    public function goodsSku()
    {
        //根据商品ID查询出数据
        $goodsId=Request::get("id");
        $goods = new Goods();
        $data = $goods->getOne($goodsId);   
        $catId = $data['catId'];
        $attributes=Attributes::getAttr($catId,1);
        foreach ($attributes as $k=>$v) {
            $attributes[$k]['attrValue'] = AttributesValue::getAttrValue($v->attrId);
        }
        //品牌
         $brand = new Brand();
        $brandData = $brand->brandOne(['brandId'=>$data['brandId']]);
        
        //sku数量
        $num=new GoodsSku();
        $numData=$num->skuNum($goodsId);
        
        return view("admin.product.goodsSku",[
            "goods"=>$data,
            "attributes"=>$attributes,
            "brand"=>$brandData,
            "num"=>$numData,
            
            ]);
     
    }
    
    //查看本商品sku的属性
    public function skuOne()
    {
        $id=Request::get("goodsId");  
        
        $model=new GoodsSku();
        $data=$model->skuFirst($id);
        foreach ($data as $k=>$v)
        {
            $attrValues = explode(',',$v["attr_values"]);
            $data[$k]["attr_values"]=AttributesValue::attrValueById($attrValues)->toArray();
        }
        return view("admin.product.sku",["data"=>$data,"goodsId"=>$id]);
        
        
        
    }
    //添加sku属性
    public function skuAttr()
    {
        $skudata=Request::post();
        $model=new GoodsSku();
        $sku=$model->skuOne($skudata);
        if($sku)
        {
            return response()->json([
                "code"=>2,
                "message"=>"以为该商品添加了sku"
                
            ]);
            
        }
        else
        {
            $data=$model->addSku($skudata);
            return response()->json([
                "code"=>1,
                "message"=>"添加成功"
                
                
            ]);
            
        }
        }
    
    //删除sku属性
        public function deleteSku()
        {
            $id=Request::get("id");
            $model=new GoodsSku();
            $data=$model->delSku($id);
            if($data)
            {
                return response()->json([
                    "code"=>1,
                    "message"=>'删除成功'
                    
                ]);
            }
            else
            {
                return response()->json([
                    "code"=>2,
                    "message"=>"删除失败"
                ]);
            }
            
            
        }
    
    //后台商品展示列表
    public function productList()
    {
        $where = [];
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
        $data = $goods->paginate(10);
        foreach ($data as $k=>$v) {
            $id = explode(',',$v->goodsSpec);
            $data[$k]->goodsSpec = AttributesValue::attrValueById($id)->toArray();
        }
        $data->appends([
            'keyword' => $keyword,
            'catId' => $catId
        ]);
        return view('admin.product.productList', [
            'data' => $data,
            'goodscats' => $goodscats,
            'catId' => $catId,
            'keyword' => $keyword
        ]);
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

    //后台添加商品页面
    public function add_product()
    {
        $shops = new Shops;
        $shopData = $shops->getData();
        $brand = new Brand;
        $brandData = $brand->getData();
        $goods_cats = new Goods_cats;
        $parentCat = $goods_cats->getCatList();
        $goodscats = $goods_cats->get()->toArray();
        $brandList = $brand->getDatas();
        $goodsSpec=Attributes::getSpec(0);
        foreach ($goodsSpec as $k=>$v) {
            $goodsSpec[$k]['attrValue'] = AttributesValue::getAttrValue($v['attrId'])->toArray();
        }
        return view('admin.product.add_product', [
            'shop' => $shopData,
            'brand' => $brandData,
            'goodscats' => $goodscats,
            'parentCat'=>$parentCat,
            'brandList'=>$brandList,
            'goodsSpec'=>$goodsSpec,
        ]);
    }

    //后台执行添加商品
    public function add_product_do()
    {
        $data = Request::post();
        $data['goodsImg'] = Request::file('goodsImg');
        $rules = [
            'goodsName' => 'required',
            'goodsImg' => 'required',
            'shopId' => 'required',
            'marketPrice' => 'required',
            'shopPrice' => 'required',
            'warnStock' => 'required',
            'goodsStock' => 'required',
            'isSale' => 'required',
            'isBest' => 'required',
            'isHot' => 'required',
            'isRecom' => 'required',
            'brandId' => 'required',
            'goodsDesc' => 'required',
            'catId' => 'required',
            'goodsSpec'=>'required'
        ];
        $message = [
            'goodsName.required' => '商品名称不能为空',
            'goodsImg.required' => '商品图片不能为空',
            'shopId.required' => '商铺不能为空',
            'marketPrice.required' => '市场价不能为空',
            'shopPrice.required' => '门店价不能为空',
            'warnStock.required' => '预警库存不能为空',
            'goodsStock.required' => '商品总库存不能为空',
            'isSale.required' => '是否上架不能为空',
            'isBest.required' => '是否精品不能为空',
            'isHot.required' => '是否热销不能为空',
            'isRecom.required' => '是否推荐不能为空',
            'brandId.required' => '品牌不能为空',
            'goodsDesc.required' => '商品描述不能为空',
            'catId.required' => '商品分类不能为空',
            'goodsSpec.required' => '商品基本属性（规格）不能为空'
        ];
        $validate = validator::make($data, $rules, $message);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            foreach ($errors as $key => $v) {
                return response()->json([
                    'code' => 2,
                    'message' => $errors[$key][0]
                ]);
            }
        }
        unset($data['_token']);
        $file = $data['goodsImg'];
        $oldName = $file->getClientOriginalName();//文件原名称
        $lastName = $file->getClientOriginalExtension();//文件后缀名
        $oldPath = $file->getRealPath();//文件临时路径
        $fileName = date('Y-m-d H-i-s').'-'.uniqid().'.'.$lastName;
        $bool = Storage::disk('uploads/product')->put($fileName, file_get_contents($oldPath));
        $data['goodsImg'] = "uploads/product/".$fileName;
        $data['goodsStatus'] = 1;
        $data['saleTime'] = date('Y-m-d H:i:s');
        $data['visitNum'] = 0;
        $data['appraiseNum'] = 0;
        $data['saleNum'] = 0;
        $data['addTime'] = date('Y-m-d H:i:s');
        $goods = new Goods;
        $res = $goods->addData($data);
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

    //后台执行删除商品
    public function product_del()
    {
        $id = Request::get('id');
        $goods = new Goods;
        $res = $goods->delData($id);
        if ($res) {
            return redirect('admin/product/productList');
        } else {
            return redirect('admin/product/productList');
        }
    }

    //后台修改商品信息页面
    public function product_update()
    {
        $id = Request::get('id');
        $goods = new Goods;
        $goodsData = $goods->getOne($id);
        $shops = new Shops;
        $shopData = $shops->getData();
        $brand = new Brand;
        $brandData = $brand->getData();
        $goods_cats = new Goods_cats;
        $parentCat = $goods_cats->getCatList();
        $goodscats = $goods_cats->get()->toArray();
        $brandList = $brand->getDatas();
        $goodsSpec=Attributes::getSpec(0);
        foreach ($goodsSpec as $k=>$v) {
            $goodsSpec[$k]['attrValue'] = AttributesValue::getAttrValue($v['attrId'])->toArray();
        }
        $catSpec=Attributes::getAttr($goodsData['catId'],0);
        foreach ($catSpec as $k=>$v) {
            $catSpec[$k]['attrValue'] = AttributesValue::getAttrValue($v['attrId']);
        }
        $goodsCatsModel = new Goods_cats();
        $parentId3 = $goodsCatsModel->getOne($goodsData['catId']);
        $catList3 = $goodsCatsModel->getSons($parentId3['parentId'])->toArray();
        $parentId2 = $goodsCatsModel->getOne($catList3[0]['parentId']);
        $catList2 = $goodsCatsModel->getSons($parentId2['parentId'])->toArray();
        $parentId1 = $goodsCatsModel->getOne($catList2[0]['parentId']);
        $catList1 = $goodsCatsModel->getSons($parentId1['parentId'])->toArray();
        $catBrand = $brand->getDatas(['brand.catId'=>$goodsData['catId']])->toArray();
        $goodsSpecValue = explode(',',$goodsData['goodsSpec']);
        return view('admin.product.product_update', [
            'goods'=>$goodsData,
            'shops' => $shopData,
            'brand' => $brandData,
            'catList' => $goodscats,
            'parentCat'=>$parentCat,
            'brandList'=>$brandList,
            'goodsSpec'=>$goodsSpec,
            'parentId1'=>$parentId1,
            'parentId2'=>$parentId2,
            'parentId3'=>$parentId3,
            'catList1'=>$catList1,
            'catList2'=>$catList2,
            'catList3'=>$catList3,
            'catBrand'=>$catBrand,
            'catSpec'=>$catSpec,
            'goodsSpecValue'=>$goodsSpecValue
        ]);
    }

    //后台产看相片详情页面
    public function product_show()
    {
        $id = Request::get('id');
        $goods = new Goods;
        $data = $goods->getOne($id);
        return view('admin/product/product_show', ['data' => $data]);
    }

    //后台执行修改商品
    public function product_update_do()
    {
        $data = Request::all();
        unset($data['_token']);
        if(!empty(Request::file('goodsImg'))){
            $file = Request::file('goodsImg');
            // if (empty($file)) {
            //     return redirect('admin/product/product_update','',0,'请选择图片');
            // }
            $oldName = $file->getClientOriginalName();//获取原文件名
            $lastName = $file->getClientOriginalExtension();//获取文件后缀名
            $tmpName = $file->getRealPath();//获取文件临时路径
            $img = date('Y-m-d H-i-s').'-'.uniqid().'.'.$lastName;
            $boll = Storage::disk('uploads/product')->put($img, file_get_contents($tmpName));
            $data['goodsImg'] = 'uploads/product/'.$img;
        }else{
            $img = $data['oldImgSrc'];
        }
        unset($data['oldImgSrc']);
        $data['goodsStatus'] = 1;
        $data['saleTime'] = date('Y-m-d H:i:s');
        $data['visitNum'] = 0;
        $data['appraiseNum'] = 0;
        $data['addTime'] = date('Y-m-d H:i:s');
        $id = $data['goodsId'];
        $goods = new Goods;
        $res = $goods->updateData($id, $data);
        if ($res) {
            return response()->json([
                'code'=>1,
                'message'=>'修改成功'
            ]);
        } else {
            return response()->json([
                'code'=>2,
                'message'=>'修改失败'
            ]);
        }
    }

    //后台批量删除所选商品
    public function product_pi()
    {
        $ids = Request::get('ids');
        $goods = new Goods;
        $res = $goods->piData($ids);
        if ($res) {
            echo 1;
        } else {
            echo 2;
        }
    }

    //后台商品分类列表展示
    public function productCategory()
    {
        $goods_cats = new Goods_cats;
        $data = $goods_cats->getData();
        // echo "<pre>";
        // print_r($data);die;
        return view('admin.product.productCategory', ['data' => $data]);
    }

    //后台添加分类页面
    public function add_category()
    {
        $goods_cats = new Goods_cats;
        $goodscats = $goods_cats->getParent();
        return view('admin.product.add_category', ['goodscats' => $goodscats]);
    }

    public function addCategoryShowParentId()
    {
        $parentId = Request::get('parentId');
        if ($parentId == '') {
            $arr = [
                'code' => 3,
                'message' => '请选择分类',
            ];
            return response()->json($arr);
        } elseif ($parentId == 0) {
            die;
        } else {
            $goods_cats = new Goods_cats;
            $data = $goods_cats->getSons($parentId);
            $arr = $data ? ['code' => 1, 'message' => '查询成功', 'data' => $data] : ['code' => 0, 'message' => '查询失败', 'data' => ''];
            return response()->json($arr);
        }
    }

    //后台执行添加分类
    public function add_category_do()
    {
        $data = Request::post();
        unset($data['_token']);
        if (!empty($data['towCatId'])) {
            $path = $data['parentId'].'-'.$data['towCatId'];
            $data['parentId'] = $data['towCatId'];
            unset($data['towCatId']);
            $catName = $data['catName'];
            $goods_cats = new Goods_cats;
            $checkName = $goods_cats->checkName($catName);
            if (!$checkName) {
                $res = $goods_cats->addData($data);
                $arr['path'] = $path.'-'.$res;
                $result = $goods_cats->updateHuiFu($res, $arr);
                if ($result) {
                    return redirect('admin/product/productCategory');
                } else {
                    return redirect('admin/product/add_product');
                }
            } else {
                $arr = [
                    'code' => 4,
                    'message' => '分类已存在',
                ];
                return response()->json($arr);
            }
        } else {
            unset($data['towCatId']);
            $catName = $data['catName'];
            $goods_cats = new Goods_cats;
            $result = $goods_cats->checkName($catName);
            if (!$result) {
                $res = $goods_cats->addData($data);
                $arr['path'] = $data['parentId'].$res;
                $result = $goods_cats->updateHuiFu($res, $arr);
                if ($result) {
                    return redirect('admin/product/productCategory');
                } else {
                    return redirect('admin/product/add_product');
                }
            } else {
                $arr = [
                    'code' => 4,
                    'message' => '分类已存在',
                ];
                return response()->json($arr);
            }
        }
        // if($result){
        //     unset($data['catName']);
        //     $data['catName'] = $data['sonName'];
        //     unset($data['sonName']);
        //     $data['parentId'] = $result['catId'];
        //     $jieguo = $goods_cats->addData($data);
        //     if ($jieguo) {
        //         return redirect('admin/product/productCategory');
        //     }else{
        //         return redirect('admin/product/add_category');
        //     }
        // }else{
        //     $son['catName'] = $data['sonName'];
        //     unset($data['sonName']); 
        //     $lastId = $goods_cats->addGetId($data);
        //     $son['parentId'] = $lastId;
        //     $sin['isShow'] = $data['isShow'];
        //     $res = $goods_cats->addData($son);
        //     if ($res) {
        //         return redirect('admin/product/productCategory');
        //     }else{
        //         return redirect('admin/product/add_category');
        //     }
        // }

    }

    //后台添加子分类页面
    public function add_category_son()
    {

        $goods_cats = new Goods_cats;
        $data = $goods_cats->getParent();
        return view('admin.product.add_category_son', ['data' => $data]);
    }

    ////后台执行添加子分类
    public function add_category_son_do()
    {
        $data = Request::post();
        unset($data['_token']);
        $goods_cats = new Goods_cats;
        $res = $goods_cats->addData($data);
        if ($res) {
            return redirect('admin/product/productCategory');
        } else {
            return redirect('admin/product/add_category_son_do');
        }
    }

    //递归方法
    // public function getTree($data,$pid)
    // {
    //     $result = array();
    //     foreach($data as $key=>$value)
    //     {
    //         if($pid == $value['parentId'])
    //         {
    //             $result[$key] = $value;
    //             $result[$key]['son'] = $this->getTree($data,$value['catId']);
    //         }
    //     }

    //      return array_values($result);
    // }

    //后台执行删除分类
    public function category_del()
    {
        $id = Request::get('id');
        $goods_cats = new Goods_cats;
        $res = $goods_cats->delData($id);
        $sonId = $goods_cats->getOneSon($id);
        $res1 = $goods_cats->delPi($sonId);
        if ($res && $res1) {
            return redirect('admin/product/productCategory');
        } else {
            return redirect('admin/product/productCategory');
        }
    }

    //后台执行批量删除分类
    public function category_pi()
    {
        $ids = Request::get('ids');
        $goods_cats = new Goods_cats;
        $par = $goods_cats->delPi($ids);
        $result = $goods_cats->getSon($ids);

        if ($result) {
            $goods_cats->delPi($result);
            echo 1;
        } else {
            echo 2;
        }

    }

    //后台执行放入回收站
    public function category_hui()
    {
        $id = Request::get('id');
        $goods_cats = new Goods_cats;
        $data = $goods_cats->getOne($id);
        $data['isHui'] = 0;
        $data['addTime'] = date('Y-m-d H:i:s');
        $res = $goods_cats->updateHuiFu($id, $data);
        if ($res) {
            // $result = $goods_cats->getOneSon($id);
            // var_dump($result);die;
            // $arr['isHui'] = 0;
            // $goods_cats->updateHui($result,$arr);
            return redirect('admin/product/productCategory');
        } else {
            return redirect('admin/product/productCategory');
        }
    }

    //后台回收站页面
    public function recycleBin()
    {
        $goods_cats = new Goods_cats;
        $data = $goods_cats->getHuiData();
        return view('admin.product.recycleBin', ['data' => $data]);
    }

    //后台执行分类恢复
    public function product_yesHui()
    {
        $id = Request::get('id');
        $goods_cats = new Goods_cats;
        $data = $goods_cats->getOne($id);
        $data['isHui'] = 1;
        $data['addTime'] = date('Y-m-d H:i:s');
        $res = $goods_cats->updateHuiFu($id, $data);
        if ($res) {
            return redirect('admin/product/productCategory');
        } else {
            return redirect('admin/product/recycleBin');
        }

    }

    //后台执行分类彻底删除
    public function product_yesDel()
    {

        $id = Request::get('id');
        $goods_cats = new Goods_cats;
        $res = $goods_cats->delData($id);
        $sonId = $goods_cats->getOneSon($id);
        $res1 = $goods_cats->delPi($sonId);
        if ($res) {
            return redirect('admin/product/recycleBin');
        } else {
            return redirect('admin/product/recycleBin');
        }
    }

    //后台执行批量删除回收站
    public function recycle_piDel()
    {
        $ids = Request::get('ids');
        $goods_cats = new Goods_cats;
        $res = $goods_cats->delPi($ids);

        if ($res) {
            echo 1;
        } else {
            echo 2;
        }
    }
    //批量恢复怎么做？？
    // public function recycle_piHui()
    // {
    //     $ids = Request::get('ids');
    //     $goods_cats = new Goods_cats;
    //     $data = $goods_cats->piHui($ids);

    //      $res = $goods_cats->updatePiHui($id,$data);

    //     if ($res) {
    //         echo 1;
    //     }else{
    //         echo 2;
    //     }

    // }


}