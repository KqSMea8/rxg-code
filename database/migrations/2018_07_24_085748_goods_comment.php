<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GoodsComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_comment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id')->comment('自增ID');
            $table->integer('member_id')->comment('用户ID');
            $table->integer('goods_id')->comment('商品ID');
            $table->tinyInteger('status')->comment('反馈状态：1：默认 2:已删除');
            $table->text('content')->comment('评论内容');
            $table->tinyInteger('member_unread')->comment('用户的未读消息（0无 1有）');
            $table->tinyInteger('shop_unread')->comment('店铺的未读消息（0无 1有 3已回复）');
            $table->dateTime('created_time')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_comment');
    }
}
