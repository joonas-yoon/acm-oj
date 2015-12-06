<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('problem_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('time')->default(-1);
            $table->integer('memory')->default(-1);
            $table->integer('size');
            $table->boolean('is_hidden')->default(0);
            $table->boolean('is_published')->default(1);
            $table->timestamps();

            $table->foreign('problem_id')->references('id')->on('problems')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('codes', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('solutions')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->text('code');
            $table->primary('id');
        });

        // ----------------------------------------------------------
        // ----------------------------------------------------------

        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('lang_id')->unsigned()->after('id');
            $table->foreign('lang_id')->references('id')->on('languages');
        });

        // ----------------------------------------------------------
        // ----------------------------------------------------------

        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('class_name');
            $table->string('remark'); // 비고
            $table->integer('published')->default(1); // 외부 공개
        });

        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('result_id')->unsigned()->after('id');
            $table->foreign('result_id')->references('id')->on('results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('codes');
        Schema::drop('solutions');

        Schema::drop('results');
        Schema::drop('languages');
    }
}
