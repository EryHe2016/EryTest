<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分类名称');
            $table->tinyInteger('status')->comment('分类状态 0关闭 1开启')->default(0);
            $table->integer('p_id')->comment('父分类id')->default(0);
            $table->string('img_path')->comment('分类图片路径');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cates');
    }
}
