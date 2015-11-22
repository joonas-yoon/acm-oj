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

        /**
         * <Bug report>
         *
         * Solutions테이블에 들어있는 데이터 때문임
         * 데이터가 이미 들어있기때문에
         * result_id를 추가하는순간
         * Default로 0이 들어가는데
         * 이 순간에 solution_results로 포린키를 걸려고 하면
         * Solution_results 에 id 0인 데이터가 없기때문에
         * 포린키 설정이 불가능한거임
         *
         * 따라서, solutions 테이블을 비우고 컬럼을 추가해야함.
         */

         /**
          * delete from solutions;
          * alter table solutions drop column result_id;
          * drop table solution_results;
          * select count(*) from solutions;
          */

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
        Schema::table('solutions', function(Blueprint $table) {
            $table->dropForeign('solutions_result_id_foreign');
            $table->dropColumn('result_id');
        });

        Schema::drop('solution_results');
    }
}
