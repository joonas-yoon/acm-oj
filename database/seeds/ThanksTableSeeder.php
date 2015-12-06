<?php

use Illuminate\Database\Seeder;

class ThanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('problem_thank')->truncate();
        DB::table('thanks')->truncate();

        $stuffs = [
            ['name' => '작성자'],
            ['name' => '번역'],
            ['name' => '오타 수정'],
            ['name' => '데이터 추가'],
            ['name' => '데이터 수정']
        ];
        foreach($stuffs as $stuff){
            DB::table('thanks')->insert(
                array (
                    'name' => $stuff['name']
                )
            );
        }
    }
}
