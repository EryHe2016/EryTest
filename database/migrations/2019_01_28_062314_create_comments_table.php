<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('评论标题');
            $table->string('content')->comment('评论内容');
            $table->integer('post_id')->commtent('文章id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('p_id')->comment('默认是0 其他的评论的回复')->default(0);
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
        Schema::drop('comments');
    }
}
