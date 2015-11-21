<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSolutionResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        create table solution_results (
            id int not null,
            name varchar(32) not null,
            primary key id
        );
        */
        Schema::create('solution_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('result')->unsigned()->default(0);
            $table->foreign('result')->references('id')->on('solution_results')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solutions', function(Blueprint $table) {
            $table->dropForeign('solutions_result_foreign');
            $table->dropColumn('result');
        });
        drop('solution_results');
    }
}
