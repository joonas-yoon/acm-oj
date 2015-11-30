<?php

use Illuminate\Database\Seeder;

class SolutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Attenction!
         * It could be deleted records existed.
         */
        App\Solution::truncate();
        DB::table('results')->truncate();
        DB::table('languages')->truncate();

        // 기본 설정 추가
        $stuffs = [
            ['desc' => '저장 중'    , 'rmk' => 'TMP', 'class_name' => 'temp hidden'],
            ['desc' => '대기 중'    , 'rmk' => 'QUE', 'class_name' => 'wait'],
            ['desc' => '채점 중'    , 'rmk' => 'RUN', 'class_name' => 'running'],
            ['desc' => '맞았습니다!', 'rmk' => 'ACC', 'class_name' => 'accept'],
            ['desc' => '틀렸습니다' , 'rmk' => 'WA' , 'class_name' => 'wrong error'],
            ['desc' => '컴파일 에러', 'rmk' => 'CLE', 'class_name' => 'compile error'],
            ['desc' => '런타임 에러', 'rmk' => 'RTE', 'class_name' => 'runtime error'],
            ['desc' => '시간 초과',   'rmk' => 'TLE', 'class_name' => 'time limit error'],
            ['desc' => '메모리 초과', 'rmk' => 'MLE', 'class_name' => 'memory limit error'],
            ['desc' => '출력 초과',   'rmk' => 'PLE', 'class_name' => 'print limit error'],
            ['desc' => '출력 형식이 잘못되었습니다', 'rmk' => 'PE', 'class_name' => 'presentation error'],
            ['desc' => '관리자 문의', 'rmk' => 'ETC', 'class_name' => '']
        ];
        foreach($stuffs as $stuff){
            DB::table('results')->insert(
                array (
                    'description' => $stuff['desc'],
                    'remark'      => $stuff['rmk'],
                    'class_name'  => $stuff['class_name'],
                    'published'   => ($stuff['rmk']=='TMP' ? 0:1)
                )
            );
        }

        // 기본 설정 추가
        $stuffs = ['C', 'C++', 'C++14'];
        foreach($stuffs as $stuff){
            DB::table('languages')->insert(
                array (
                    'name' => $stuff
                )
            );
        }

        factory('App\Solution', 100)->create();
    }
}
