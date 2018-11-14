<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('userId')->comment('用户id');
            // $table->timestamps()->default('');
            $table->string('username',20)->comment('用户名');
            $table->string('password',50)->comment('密码');
            $table->tinyInteger('sex')->comment(' 性别 0:女 1:男');
            $table->string('qq',15)->comment('用户qq');
            $table->string('weixin',30)->comment('用户微信');
            $table->string('tel',11)->comment('手机号码');
            $table->string('email',50)->comment('邮箱');
            $table->string('trueName',20)->comment('真实姓名');
            $table->string('userPhoto',50)->comment('用户头像');
            $table->tinyInteger('type')->comment('用户类型 0:超级管理员 1:普通用户 2:店铺用户');
            $table->string('lastIp',20)->comment('用户最后登录的ip地址');
            $table->tinyInteger('status')->comment('用户状态')->default(0);
            $table->string('regTime',50)->default('')->comment('注册时间');
            $table->tinyInteger("address_id")->comment("地址ID");
//            $table->timestamp('regTime')->useCurrent()->comment('注册时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_user');
    }
}
