<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call(UsersTableSeeder::class);
        $this->command->info('users table seeded');

        $this->call(ProblemsTableSeeder::class);
        $this->command->info('problems table seeded');

        $this->call(SolutionsTableSeeder::class);
        $this->command->info('solutions table seeded');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Model::reguard();
    }
}
