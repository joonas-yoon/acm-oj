<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	/**
	 * The attributes that are fillable via mass assignment.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'description'];

	/**
	 * The attributes included in the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = ['id', 'name'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * Roles can belong to many users.
	 *
	 * @return Model
	 */
	public function users()
	{
		return $this->belongsToMany(Config::get('App\User'))->withTimestamps();
	}

	/**
	 * Roles can have many permissions.
	 *
	 * @return Model
	 */
	public function permissions()
	{
		return $this->belongsToMany('App\Permission')->withTimestamps();
	}

	/**
	 * Get a list of permissions.
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		return $this->permissions->lists('slug');
	}

	/**
	 * Checks if the role has the given permission.
	 *
	 * @param  string $permission
	 * @return bool
	 */
	public function can($permission)
	{
		$permissions = $this->getPermissions();

		if (is_array($permission)) {
			$permissionCount    = count($permission);
			$intersection       = array_intersect($permissions, $permission);
			$intersectionCount  = count($intersection);

			return ($permissionCount == $intersectionCount) ? true : false;
		} else {
			return in_array($permission, $permissions);
		}		
	}

	/**
	 * Assigns the given permission to the role.
	 *
	 * @param  int $permissionId
	 * @return bool
	 */
	public function assignPermission($permissionId = null)
	{
		$permissions = $this->permissions;

		if (! $permissions->contains($permissionId)) {
			return $this->permissions()->attach($permissionId);
		}

		return false;
	}

	/**
	 * Revokes the given permission from the role.
	 *
	 * @param  int $permissionId
	 * @return bool
	 */
	public function revokePermission($permissionId = '')
	{
		return $this->permissions()->detach($permissionId);
	}

	/**
	 * Syncs the given permission(s) with the role.
	 *
	 * @param  array $permissionIds
	 * @return bool
	 */
	public function syncPermissions(array $permissionIds)
	{
		return $this->permissions()->sync($permissionIds);
	}

	/**
	 * Revokes all permissions from the role.
	 *
	 * @return bool
	 */
	public function revokeAllPermissions()
	{
		return $this->permissions()->detach();
	}

}
