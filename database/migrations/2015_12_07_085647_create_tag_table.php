<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
           $table->increments('id');
           $table->string('name', 30);
           $table->unique('name');
           $table->integer('status')->unsigned()->default(0);
        });

        Schema::create('problem_tag', function(Blueprint $table) {
           $table->increments('id');
           $table->integer('problem_id')->unsigned();
           $table->foreign('problem_id')->references('id')->on('problems');
           $table->integer('tag_id')->unsigned();
           $table->foreign('tag_id')->references('id')->on('tags');
           $table->integer('count')->unsigend()->default(0);
           $table->unique(['problem_id', 'tag_id']);
        });

        Schema::create('user_tag', function(Blueprint $table) {
           $table->increments('id');
           $table->integer('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users');
           $table->integer('problem_id')->unsigned();
           $table->foreign('problem_id')->references('id')->on('problems');
           $table->integer('tag_id')->unsigned();
           $table->foreign('tag_id')->references('id')->on('tags');
           $table->unique(['user_id', 'problem_id', 'tag_id']);
        });

        Schema::create('selected_tag', function(Blueprint $table) {
           $table->integer('problem_tag_id')->unsigned();
           $table->foreign('problem_tag_id')->references('id')->on('problem_tag');
           $table->integer('problem_id')->unsigned();
           $table->foreign('problem_id')->references('id')->on('problems');
           $table->timestamps();
           $table->primary('problem_tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('selected_tag');
        Schema::drop('user_tag');
        Schema::drop('problem_tag');
        Schema::drop('tags');
    }
}
