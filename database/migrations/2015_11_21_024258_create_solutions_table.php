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
        /*
        create table solutions (
            id int not null auto_increment,
            problem_id int not null,
            user_id not null,
            time int not null default -1,
            memory int not null default -1,
            size int not null,

            foriegn key problem_id(problems.id),
            foriegn key user_id(users.id),
        );
        */
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

        /*
        create table solution_codes (
            id int not null,
            code text,
            foriegn key id(solutions.id)
        );
        */
        Schema::create('solution_codes', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('solutions')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->text('code');
        });

        // ----------------------------------------------------------
        // ----------------------------------------------------------

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

        // ----------------------------------------------------------
        // ----------------------------------------------------------

        /*
        create table solution_results (
            id int not null,
            description varchar(32) not null,
            primary key id
        );
        */
        Schema::create('solution_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('class_name');
            $table->string('remark'); /* 비고. ACC, WA 등이 들어감 */
        });

        // 기본 설정 추가
        $stuffs = [
            ['desc' => '기본 값'    , 'rmk' => 'NUL', 'class_name' => ''],
            ['desc' => '대기 중'    , 'rmk' => 'QUE', 'class_name' => ''],
            ['desc' => '맞았습니다!', 'rmk' => 'ACC', 'class_name' => 'accept'],
            ['desc' => '틀렸습니다' , 'rmk' => 'WA' , 'class_name' => 'wrong error'],
            ['desc' => '컴파일 실패', 'rmk' => 'CLE', 'class_name' => 'compile error'],
            ['desc' => '런타임 에러', 'rmk' => 'RTE', 'class_name' => 'runtime error'],
            ['desc' => '관리자 문의', 'rmk' => 'ETC', 'class_name' => '']
        ];
        foreach($stuffs as $stuff){
            DB::table('solution_results')->insert(
                array (
                    'description' => $stuff['desc'],
                    'remark'      => $stuff['rmk'],
                    'class_name'  => $stuff['class_name']
                )
            );
        }

        Schema::table('solutions', function (Blueprint $table) {
            $table->integer('result_id')->unsigned()->after('id');
            $table->foreign('result_id')->references('id')->on('solution_results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solution_codes');
        Schema::drop('solutions');

        Schema::drop('solution_results');
        Schema::drop('languages');
    }
}
