<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

<<<<<<< HEAD
=======
class RxgLogistics extends Migration
>>>>>>> dcf150f7be59ba0e920635d95ad3ba6aec2188ac
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        	$table->engine = 'InnoDB';
        	$table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id')->comment('自增id');
            $table->string('name')->comment('物流公司名称');
            $table->string('tel',15)->comment('联系电话');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rxg_logistics');
    }
}
