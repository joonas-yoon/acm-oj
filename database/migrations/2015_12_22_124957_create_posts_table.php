<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_comment')->default(false);
            // is_comment: 0 => parent_id: group_id or category_id
            // is_comment: 1 => parent_id: post_id
            $table->integer('parent_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('problem_id')->unsigned()->nullable();
            $table->string('title', 100);
            $table->text('content', 100);
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
        Schema::drop('posts');
    }
}
