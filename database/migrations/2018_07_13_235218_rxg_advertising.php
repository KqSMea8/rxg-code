<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgAdvertising extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_advertising', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uname',30)->nullable();
            // $table->string('place',30)->nullable();
            $table->string('place',30)->nullable()->comment('投放位置:1.首页导航2.侧边栏3.根据客户需求');
            $table->tinyInteger('type')->nullable()->comment('类型:1.图片2.文字');
            $table->string('img',60)->nullable()->comment('图片');
            $table->text('details')->nullable()->comment('描述');
            $table->string('province',30)->nullable()->comment('省份名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_advertising');
    }
}
