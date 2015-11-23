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
        DB::table('solution_results')->truncate();
        DB::table('languages')->truncate();

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
