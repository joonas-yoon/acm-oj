<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thanks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);

        });

        Schema::create('problem_thank', function (Blueprint $table) {
           $table->integer('problem_id')->unsigned();
           $table->foreign('problem_id')->references('id')->on('problems');
           $table->integer('thank_id')->unsigned();
           $table->foreign('thank_id')->references('id')->on('thanks');
           $table->integer('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('problem_thank');
        Schema::drop('thanks');
    }
}
