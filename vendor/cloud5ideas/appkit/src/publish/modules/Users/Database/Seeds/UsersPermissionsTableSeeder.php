<?php
namespace App\Modules\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\Role;

class UsersPermissionsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$role = Role::find(1);
		
		$role->syncPermissions([
				Permission::create(['name' => 'Access Users Module', 	'slug' => 'access.users', 			'description' => 'Has access to Users module.'])->id,
				Permission::create(['name' => 'Create Users', 			'slug' => 'create.users', 			'description' => 'Can create records in Users module.'])->id,
				Permission::create(['name' => 'View Users', 			'slug' => 'view.users', 			'description' => 'Can view records in Users module.'])->id,
				Permission::create(['name' => 'Edit Users', 			'slug' => 'edit.users', 			'description' => 'Can edit records in Users module.'])->id,
				Permission::create(['name' => 'Delete Users', 			'slug' => 'delete.users', 			'description' => 'Can delete records in Users module.'])->id,
				Permission::create(['name' => 'Disable Users', 			'slug' => 'disable.users', 			'description' => 'Can disable application users.'])->id,
				Permission::create(['name' => 'Enable Users', 			'slug' => 'enable.users', 			'description' => 'Can enable application users.'])->id,
				Permission::create(['name' => 'Set Permissions', 		'slug' => 'set.user.permissions',	'description' => 'Can can set application user permissions.'])->id
			]);
	}

}
