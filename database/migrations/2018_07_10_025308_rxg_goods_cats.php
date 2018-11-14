<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgGoodsCats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_goods_cats', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('catId')->comment('自增ID');
            $table->integer('parentId')->comment('父ID');
            $table->string('catName',30)->comment('分类名称');
            $table->tinyInteger('isShow')->comment('是否显示')->default(1);
            $table->tinyInteger('isFloor')->comment('是否显示楼层')->default(1);
            $table->tinyInteger('isHUI')->comment('是否放入回收站')->default(1);
            $table->string('addTime',50)->default('')->comment('添加时间');
//            $table->timestamp('addTime')->useCurrent()->comment('添加时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_goods_cats');
    }
}
