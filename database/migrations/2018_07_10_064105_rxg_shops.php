<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgShops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_shops', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('shopId');
            $table->string('shopSn',30)->comment('门店编号');
            $table->integer('userId')->comment('门店所有者ID');
            $table->string('areaIdPath',30)->comment('区域路径');
            $table->tinyInteger('isSelf')->default(1)->comment('是否自营 1:自营 0:非自营');
            $table->string('shopName',100)->comment('门店名称');
            $table->string('shopkeeper',20)->comment('店主');
            $table->string('telephone',11)->comment('店主手机号');
            $table->string('shopCompany',30)->default('')->comment('公司名称');
            $table->string('shopImg',200)->default('')->comment('门店图标');
            $table->string('shopTel',11)->default('')->comment('门店电话');
            $table->string('shopQQ',15)->default('')->comment('门店QQ');
            $table->string('shopAddress',50)->default('')->comment('门店地址');
            $table->string('bankNo',50)->comment('银行卡号');
            $table->string('bankUserName',20)->comment('银行卡所有者姓名');
            $table->tinyInteger('isInvoice')->default(1)->comment('能否开发票 1:能 0:不能');
            $table->tinyInteger('isVerify')->default(0)->comment('审核信息 1:审核通过 0:未审核 2:审核未通过');
            $table->decimal('freight',10,2)->default(0.00)->comment('默认运费');
            $table->tinyInteger('shopStatus')->default(1)->comment('门店状态   1:正常   0:异常');
            $table->decimal('shopMoney',10,2)->default(0.00)->comment('商家钱包');
            $table->string('addTime',50)->default('');
            $table->string('pwd',32)->default('密码');
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
        Schema::dropIfExists('rxg_shops');
    }
}
