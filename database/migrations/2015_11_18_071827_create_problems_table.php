<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 60);
            $table->longText('description')->nullable();
            $table->integer('time_limit')->unsigned()->default(0);
            $table->integer('memory_limit')->unsigned()->default(128);
            $table->text('input')->nullable();
            $table->text('output')->nullable();
            $table->text('sample_input')->nullable();
            $table->text('sample_output')->nullable();
            $table->text('hint')->nullable();

            $table->boolean('is_special')->default(0);
            $table->integer('status')->default(0)
                  ->comment('비공개/공개/..');
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
        Schema::drop('problems');
    }
}
