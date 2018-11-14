<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//首次访问进入首页
Route::any("/", "Home\IndexController@index");
Route::any("admin/login/{action?}", function (App\Http\Controllers\Admin\LoginController $index, $action = 'login') {
    return $index->$action();
});
Route::get('goods/detail','Home\GoodsController@detail');
Route::middleware(['checkPower'])->group(function () {
    Route::any("admin/index/{action?}", function (App\Http\Controllers\Admin\IndexController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("admin/order/{action?}", function (App\Http\Controllers\Admin\OrderController $index, $action = 'order_list') {
        return $index->$action();
    });

    Route::any("admin/product/{action?}", function (App\Http\Controllers\Admin\ProductController $index, $action = 'productList') {
        return $index->$action();
    });
    Route::any("admin/permission/{action?}", function (App\Http\Controllers\Admin\PermissionController $index, $action = 'root') {
        return $index->$action();
    });

    Route::any("admin/user/{action?}", function (App\Http\Controllers\Admin\UserController $index, $action = 'userList') {
        return $index->$action();
    });

    Route::any("admin/advertising/{action?}", function (App\Http\Controllers\Admin\AdvertisingContrller $index, $action = 'advertising_list') {
        return $index->$action();
    });

    Route::any("admin/store/{action?}", function (App\Http\Controllers\Admin\StoreController $index, $action = 'store_information') {
        return $index->$action();
    });
    Route::any("admin/activity/{action?}", function (App\Http\Controllers\Admin\ActivityController $index, $action = 'activityList') {
        return $index->$action();
    });
    Route::any("admin/solideshow/{action?}", function (App\Http\Controllers\Admin\SolideShowController $index, $action = 'solideshowList') {
        return $index->$action();
    });
    Route::any("admin/feedback/{action?}", function (App\Http\Controllers\Admin\FeedBackController $index, $action = 'feedBack') {
        return $index->$action();
    });
    Route::any("admin/ticket/{action?}", function (App\Http\Controllers\Admin\TicketController $index, $action = 'ticket') {
    return $index->$action();
    });
    Route::any("admin/brand/{action?}", function (App\Http\Controllers\Admin\BrandController $index, $action = 'brandList') {
        return $index->$action();
    });
    Route::any("admin/attribute/{action?}", function (App\Http\Controllers\Admin\AttributeController $index, $action = 'attributeList') {
        return $index->$action();
    });
});
//前台路由组
Route::get('goods/goodsList','Home\GoodsController@goodsList');
Route::get('shop/shops','Home\ShopController@shops');
Route::middleware(['checkUserLogin'])->group(function (){
    Route::any("order/{action?}", function (App\Http\Controllers\Home\OrderController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("collect/{action?}", function (App\Http\Controllers\Home\CollectController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("user/{action?}", function (App\Http\Controllers\Home\UserController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("cart/{action?}", function (App\Http\Controllers\Home\CartController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("sales/{action?}", function (App\Http\Controllers\Home\SalesController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("consult/{action?}", function (App\Http\Controllers\Home\ConsultController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("shop/{action?}", function (App\Http\Controllers\Home\ShopController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("address/{action?}", function (App\Http\Controllers\Home\AddressController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("feedback/{action?}", function (App\Http\Controllers\Home\FeedbackController $index, $action = 'feedback') {
        return $index->$action();
    });
    Route::any("shop/{action?}", function (App\Http\Controllers\Home\ShopController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("address/{action?}", function (App\Http\Controllers\Home\AddressController $index, $action = 'index') {
        return $index->$action();
    });
    Route::any("feedback/{action?}", function (App\Http\Controllers\Home\FeedbackController $index, $action = 'feedback') {
        return $index->$action();
    });
    Route::any("goods/{action?}", function (App\Http\Controllers\Home\GoodsController $index, $action = 'index') {
        return $index->$action();
    });
});
//前台路由
Route::any("index/{action?}", function (App\Http\Controllers\Home\IndexController $index, $action = 'index') {
    return $index->$action();
});
Route::any("login/{action?}", function (App\Http\Controllers\Home\LoginController $index, $action = 'login') {
    return $index->$action();
});

//商家后台路由
Route::any("merchant/register/{action?}", function (App\Http\Controllers\Merchant\RegisterController $index, $action = 'register') {
    return $index->$action();
});
Route::any("merchant/login/{action?}", function (App\Http\Controllers\Merchant\LoginController $index, $action = 'index') {
    return $index->$action();
});
Route::any("merchant/index/{action?}", function (App\Http\Controllers\Merchant\IndexController $index, $action = 'index') {
    return $index->$action();
});
Route::any("merchant/merchant/{action?}", function (App\Http\Controllers\Merchant\MerchantController $index, $action = 'index') {
    return $index->$action();
});
Route::any("merchant/goods/{action?}", function (App\Http\Controllers\Merchant\GoodsController $index, $action = 'goodsList') {
    return $index->$action();
});
Route::any("merchant/comment/{action?}", function (App\Http\Controllers\Merchant\CommentController $index, $action = 'comment') {
    return $index->$action();
});


Route::any("merchant/order/{action?}", function (App\Http\Controllers\Merchant\OrderController $index, $action = 'order') {
    return $index->$action();
});

Route::any("merchant/logistics/{action?}", function (App\Http\Controllers\Merchant\LogisticsController $index, $action = 'logisticslist') {
    return $index->$action();
});

Route::get('flush','FlushController@index');
