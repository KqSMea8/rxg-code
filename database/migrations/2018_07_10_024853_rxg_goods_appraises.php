<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgGoodsAppraises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_goods_appraises', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id')->comment('自增ID');
            $table->integer('shopId')->comment('门店ID');
            $table->integer('orderId')->comment('订单ID');
            $table->integer('goodsId')->comment('评价对象ID');
            $table->integer('goodsSpecId')->comment('商品-规格Id');
            $table->integer('userId')->comment('会员ID');
            $table->integer('goodsScore')->comment('商品评分');
            $table->integer('serviceScore')->comment('服务评分');
            $table->integer('timeScore')->comment('时效评分');
            $table->text('content')->comment('点评内容');
            $table->text('shopReply')->comment('店铺回复');
            $table->text('images')->comment('上传图片');
            $table->tinyInteger('isShow')->comment('是否显示 1:显示 0:隐藏')->default(1);
            $table->tinyInteger('dataFlag')->comment('有效状态 1:有效 -1:无效')->default(1);
//            $table->timestamp('createTime')->useCurrent()->comment('添加时间');
            $table->string('createTime',50)->default('')->comment('添加时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_goods_appraises');
    }
}
