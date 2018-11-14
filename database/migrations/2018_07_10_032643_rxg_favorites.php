<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgFavorites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_favorites', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('favoriteId');
            $table->integer('userId');
            $table->tinyInteger('favoriteType')->comment('关注类型 0:店铺 1:商品');
            $table->integer('objectId')->comment('关注对象（店铺/商品）的id');
//            $table->timestamp('addTime')->useCurrent();
            $table->string('addTime',50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_favorites');
    }
}
