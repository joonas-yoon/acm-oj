<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
           $table->integer('problem_id')->unsigned();
           $table->foreign('problem_id')->references('id')->on('problems');
           $table->integer('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users');
           $table->integer('result_id')->unsigned();
           $table->foreign('result_id')->references('id')->on('results');
           $table->integer('count')->unsigned()->default(0);
           $table->primary(['problem_id', 'user_id', 'result_id']);
        });

        Schema::create('problem_statistics', function (Blueprint $table) {
            $table->integer('problem_id')->unsigned();
            $table->foreign('problem_id')->references('id')->on('problems');
            $table->integer('result_id')->unsigned();
            $table->foreign('result_id')->references('id')->on('results');
            $table->integer('count')->unsigned()->default(0);
            $table->primary(['problem_id', 'result_id']);
        });

        Schema::create('user_statistics', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('result_id')->unsigned();
            $table->foreign('result_id')->references('id')->on('results');
            $table->integer('count')->unsigned()->default(0);
            $table->primary(['user_id', 'result_id']);
        });


        Schema::table('problems', function (Blueprint $table) {
            $table->integer('total_submit')->unsigend()->default(0);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_submit')->unsigend()->default(0);
            $table->integer('total_clear')->unsigend()->default(0);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->dropColumn('total_submit');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('total_submit');
            $table->dropColumn('total_clear');
        });

        Schema::drop('problem_statistics');
        Schema::drop('user_statistics');
        Schema::drop('statistics');
    }
}
