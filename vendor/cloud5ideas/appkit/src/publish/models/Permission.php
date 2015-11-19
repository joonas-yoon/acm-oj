<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

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
	protected $table = 'permissions';

	/**
	 * Permissions can belong to many roles.
	 *
	 * @return Model
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Role')->withTimestamps();
	}

}
