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
            $table->string('description');
        });

        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('result_id')->unsigned()->default(0);
            $table->foreign('result_id')->references('id')->on('solution_results')
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
            // 이 부분을 고쳐야 하는 데.....
            $table->dropForeign('solutions_result_id_foreign');
            $table->dropColumn('result_id');
        });
        Schema::drop('solution_results');
    }
}
