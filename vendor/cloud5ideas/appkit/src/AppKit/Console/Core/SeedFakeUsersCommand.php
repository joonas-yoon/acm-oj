<?php namespace C5\AppKit\Console\Core;

use App\User;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Input\InputArgument;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class SeedFakeUsersCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:fake:users';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Seed some fake users.';

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$count = 24;

		if ($this->argument('count')) {
			$count = $this->argument('count');
		}

		DB::table('users')->where('id', '>', 1)->delete();
        $faker = Factory::create();

        for ($i=1; $i < $count; $i++) { 
            User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => bcrypt($faker->password),
                'is_superuser' => $faker->boolean(),
                'is_disabled' => $faker->boolean(),
                'image' => $faker->imageUrl(300, 300),
                'key' => str_random(21)
            ]);
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['count', InputArgument::OPTIONAL, 'How many users to create.']
		];
	}
}
