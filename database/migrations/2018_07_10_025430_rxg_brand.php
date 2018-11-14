<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_brand', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('brandId');
            $table->string('brandName',20)->comment('品牌名称');
            $table->string('brandImg',50)->comment('品牌图表');
            $table->text('brandDesc')->comment('品牌介绍');
            $table->tinyInteger('catId')->comment('分类id');
            $table->tinyInteger('status')->comment('品牌状态 0:不可用 1:可用')->default(0);
            $table->string('addTime',50)->default('')->comment('添加时间');
            $table->string('time',50)->default('')->comment('修改时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_brand');
    }
}
