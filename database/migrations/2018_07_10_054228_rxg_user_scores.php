<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgUserScores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_user_scores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('scoreId');
            $table->integer('userId');
            $table->integer('score')->default(0)->comment('积分数量');
            $table->integer('dataSrc')->default(0)->comment('来源 1：订单 2:评价 3：订单取消返还 4：拒收返还');
            $table->integer('dataId')->default(0)->comment('来源记录ID');
            $table->integer('scoreType')->default(0)->comment('积分表示 1：收入 2：支出');
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
        Schema::dropIfExists('rxg_user_scores');
    }
}
