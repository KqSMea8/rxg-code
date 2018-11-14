<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_activity', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->string('activityName',20)->nullable()->comment('活动名称');
            // $table->integer('catId')->comment('分类id');
            $table->integer('goodsId')->comment('商品id');
            // $table->string('activityImg',200)->comment('商品图片');
            // $table->tstring('shopName',30)->nullable()->comment('店铺名称');
            $table->text('activityDesc')->comment('活动描述');
            $table->tinyInteger('activityClass')->comment('活动类型  1:秒杀  0:限价抢购');
            $table->tstring('favourable',40)->nullable()->comment('优惠价');
            $table->string('sTime',50)->default('')->comment('活动开始时间');
            $table->string('oTime',50)->default('')->comment('结束时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_activity');
    }
}
