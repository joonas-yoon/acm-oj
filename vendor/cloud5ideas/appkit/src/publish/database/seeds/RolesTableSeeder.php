<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder {

	/**
	 * Run the Roles table seeds.
	 *
	 * @return void
	 */
	public function run()
    {
        DB::table('roles')->delete();

        foreach (config('appkit.default_roles') as $key) {
            Role::create([
                'name' => $key['name'],
                'slug' => $key['slug'],
                'description' => $key['description']
            ]);
        }
    }

}
