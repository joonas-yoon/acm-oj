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

        factory('App\Solution', 100)->create();
    }
}
