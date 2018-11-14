<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgShopProxy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_shop_proxy', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->integer('shopId')->comment('店铺id');
            $table->integer('userId')->comment('代理分销的用户id');
            $table->integer('parentUserId')->comment('代理分销的上级用户id');
            $table->string('addTime',50)->default('');
//            $table->timestamp('addTime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_shop_proxy');
    }
}
