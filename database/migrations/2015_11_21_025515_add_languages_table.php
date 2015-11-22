<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        create table languages (
            id int not null auto_increment,
            name varchar(32) not null,
            primary key id
        );
        */
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('lang_id')->unsigned()->after('id');
            $table->foreign('lang_id')->references('id')->on('languages');
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
            $table->dropForeign('solutions_lang_id_foreign');
            $table->dropColumn('lang_id');
        });
        Schema::drop('languages');
    }
}
