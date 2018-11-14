<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('payCode',100)->default('')->comment('支付code');
            $table->string('payName',100)->comment('支付方式名称');
            $table->text('payDesc')->comment('支付方式描述');
            $table->tinyInteger('enabled')->default(1)->comment('是否启用 0:不启用 1:启用');
            $table->tinyInteger('isOnline')->default(1)->comment('是否在线支付 0:否 1:在线支付');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_payments');
    }
}
