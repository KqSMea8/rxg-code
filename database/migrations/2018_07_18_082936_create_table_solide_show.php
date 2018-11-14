<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSolideShow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solide_show', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id')->comment('自增ID');
            $table->string('img_name',20)->comment('轮播图名称');
            $table->string('img_path',100)->comment('轮播图路径');
            $table->string('img_url',100)->comment('轮播图URL');
            $table->tinyInteger('is_show')->comment('是否展示');
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solide_show');
    }
}
