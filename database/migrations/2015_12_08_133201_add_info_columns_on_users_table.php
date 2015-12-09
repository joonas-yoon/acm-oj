<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoColumnsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('via')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('organization')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('email_open')->default(false)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('via');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('organization');
            $table->dropColumn('photo_path');
            $table->dropColumn('email_open');
        });
    }
}
