<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_gallery', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('galleryId')->comment('相册自增id');
            $table->integer('goodsId')->comment('商品id');
            $table->string('gallaryImg',50)->comment('相册路径');
            $table->tinyInteger('status')->comment('该相册的状态');
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
        Schema::dropIfExists('rxg_gallery');
    }
}
