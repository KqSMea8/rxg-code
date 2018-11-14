<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_admin', function (Blueprint $table) {
            $table->increments('adminId');
            $table->string('adminName',20)->comment('管理员登录账号以及用户名');
            $table->string('password',50)->comment('管理员登录密码');
            $table->tinyInteger('status')->comment('管理员状态  1:可用  0:不可用');
            $table->string('lastLoginIp',50)->nullable()->comment('管理员最后登录时的ip');
            $table->string('lastLoginTime',50)->nullable()->comment('管理员最后登录时的时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
