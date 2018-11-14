<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class GoodsCommentReply1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_comment_reply', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id')->comment('自增ID');
            $table->integer('comment_id')->comment('评论ID');
            $table->tinyInteger('type')->comment('回复类型：1：用户 2:店铺');
            $table->text('content')->comment('回复内容');
            $table->tinyInteger('status')->comment('读取状态（0已读 1未读）');
            $table->tinyInteger('shop_id')->comment('店铺ID');
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
        Schema::dropIfExists('goods_comment_reply');
    }
}
