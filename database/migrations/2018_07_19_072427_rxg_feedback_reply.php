<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgFeedbackReply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_reply', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id')->comment('自增ID');
            $table->integer('feedback_id')->comment('反馈ID');
            $table->tinyInteger('type')->comment('回复类型：1：用户 2:系统');
            $table->text('content')->comment('回复内容');
            $table->tinyInteger('status')->comment('读取状态（0已读 1未读）');
            $table->tinyInteger('p_id')->comment('管理员ID');
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
        Schema::dropIfExists('feedback_reply');
    }
}
