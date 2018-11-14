<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RxgOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxg_orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('orderId');
            $table->string('orderNo',50);
            $table->integer('shopId');
            $table->integer('userId');
            $table->tinyInteger('orderStatus')->default(-2)->comment('订单状态 -3:用户拒收 -2:未付款的订单 -1：用户取消 0:待发货 1:配送中 2:用户确认收货');
            $table->decimal('goodsMoney',11,2)->default(0.00)->comment('商品总金额 商品总价格—未进行任何折扣的总价格');
            $table->tinyInteger('deliverType')->comment('收货方式 0:送货上门 1:自提');
            $table->decimal('totalMoney',11,2)->comment('订单总金额 包括运费');
            $table->decimal('realTotalMoney',11,2)->comment('实际订单总金额 进行各种折扣之后的金额');
            $table->tinyInteger('payType')->default(1)->comment('实支付方式 0:货到付款 1:在线支付');
            $table->integer('payFrom')->comment('支付来源 1:支付宝，2：微信');
            $table->tinyInteger('isPay')->comment('是否支付 0:未支付 1:已支付');
            $table->string('userName',20)->comment('收货人名称');
            $table->string('userAddress',100)->comment('收货人地址');
            $table->string('userPhone',11)->comment('收件人手机');
            $table->integer('orderScore')->default(0)->comment('所得积分');
            $table->tinyInteger('isInvoice')->default(0)->comment('是否需要发票 1:需要 0:不需要');
            $table->string('orderRemarks',50)->default('')->comment('订单备注');
            $table->tinyInteger('isRefund')->default(0)->comment('是否退款 0:否 1：是');
            $table->tinyInteger('isAppraise')->default(0)->comment('是否评价 0:未评价 1:已评价');
            $table->string('cancelReason')->default('')->comment('取消原因');
            $table->string('rejectReason')->default('')->comment('拒收原因');
            $table->tinyInteger('isClosed')->default(0)->comment('是否订单已完结 0：未完结 1:已完结');
            $table->integer('settlementId')->default(0)->comment('是否结算，大于0的话则是结算ID');
            $table->string('receiveTime',50)->default('')->comment('收货时间');
            $table->string('deliveryTime',50)->default('')->comment('发货时间');
            $table->integer('expressId')->default(0)->comment('快递公司ID');
            $table->string('areaIdPath',30)->default('')->comment('区域Id路径 省级id市级id县级Id 例如:110000_110100_110101');
            $table->string('addTime',50)->default('')->comment('下单时间');
            $table->tinyint("is_show")->comment("是否展示");
//            $table->timestamp('addTime')->useCurrent()->comment('下单时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_orders');
    }
}
