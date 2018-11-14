<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgPower extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_power', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('powerId');
            $table->string('powerName',20);
            $table->string('powerUrl',50)->default('#')->comment('权限地址   如果没有地址为#');
            $table->integer('parentId')->comment('权限的父级id');
            $table->tinyInteger('isShow')->comment('该权限是否显示  1:显示  0:不显示');
            $table->tinyInteger('status')->comment('权限状态   1:可用  0:不可用');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_power');
    }
}
