<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        create table contributions_elements (
            id int not null auto_increment,
            name varchar(32) not null,

            primary key id
        );
        */
        Schema::create('contributions_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32);
        });

        /*
        create table problems_contributions (
            id int not null,
            type int not null,
            user_id int not null,

            foriegn key id(problems.id),
            foriegn key type(contributions_elements, id),
            foriegn key user_id(users.id)
        );
        */
        Schema::create('problems_contributions', function (Blueprint $table) {
            $table->integer('id')->unsigned()->default(0);
            $table->integer('type')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();

            $table->foreign('id')->references('id')->on('problems');
            $table->foreign('type')->references('id')->on('contributions_elements');
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
        Schema::drop('problems_contributions');
        Schema::drop('contributions_elements');
    }
}
