<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_goods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('goodsId')->comment('自增id');
            $table->string('goodsName',255)->comment('商品名称');
            $table->string('goodsImg',200)->comment('商品图片');
            $table->integer('shopId')->comment('商铺ID');
            $table->decimal('marketPrice', 11, 2)->comment('市场价');
            $table->decimal('shopPrice', 11, 2)->comment('门店价');
            $table->integer('warnStock')->comment('预警库存');
            $table->integer('goodsStock')->comment('商品总库存');
            $table->text('goodsTips')->comment('促销信息');
            $table->tinyInteger('isSale')->comment('是否上架');
            $table->tinyInteger('isBest')->comment('是否精品');
            $table->tinyInteger('isHot')->comment('是否热销产品');
            $table->tinyInteger('isRecom')->comment('是否推荐');
            $table->integer('brandId')->comment('品牌Id');
            $table->text('goodsDesc')->comment('商品描述');
            $table->tinyInteger('goodsStatus')->comment('商品状态');
            $table->integer('saleNum')->comment('总销售量');
            $table->string('saleTime',50)->default('')->comment('上架时间');
//            $table->timestamp('saleTime')->useCurrent()->comment('上架时间');
            $table->integer('visitNum')->comment('访问数');
            $table->integer('appraiseNum')->comment('评价数');
            $table->tinyInteger('isSpec')->comment('评价数');
            $table->integer('galleryId')->comment('商品相册id');
            $table->integer('catId')->comment('分类id');
            $table->integer('brandId')->comment('商品id');
            $table->integer('seriesId')->comment('系列id');
            $table->integer('attrId')->comment('属性id');
            $table->integer('attrValueId')->comment('属性值id');
            $table->string('addTime',50)->default('')->comment('创建时间');
//            $table->timestamp('addTime')->useCurrent()->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_goods');
    }
}
