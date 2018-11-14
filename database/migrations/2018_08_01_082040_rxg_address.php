<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name')->comment('收件人名称');
            $table->tinyInteger('user_id')->comment('用户ID');
            $table->string('tell')->comment('收件人电话');
            $table->tinyInteger('province')->comment('省份ID');
            $table->tinyInteger('city')->comment('城市ID');
            $table->tinyInteger('distruct')->comment('县级ID');
            $table->string('email')->comment('邮政编码');
            $table->string('street')->comment('街道');
            $table->string('addresstag')->comment('地址标签');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
