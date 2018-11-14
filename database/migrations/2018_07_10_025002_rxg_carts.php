<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgCarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_carts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('cartId');
            $table->integer('userId');
            $table->integer('goodsId');
            $table->tinyInteger('isCheck')->default(1)->comment('是否选中 0:未被选中  1:被选中');
            $table->integer('num')->default(0)->comment('商品数量');
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
        Schema::dropIfExists('carts');
    }
}
