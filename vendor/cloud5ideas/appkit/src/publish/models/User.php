<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use C5\AppKit\Traits\PermissionsTrait;
use C5\AppKit\Traits\SearchableTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, PermissionsTrait, SearchableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['first_name', 'last_name', 'email', 'password', 'is_superuser', 'is_disabled', 'image', 'key'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token', 'key'];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
	    'is_superuser' => 'boolean',
	    'is_disabled' => 'boolean',
	];

	 /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'first_name' => 10,
            'last_name' => 10,
            'email' => 10
		]
	];

	/**
	 * Make sure the email field is set to lowercase
	 *
	 * @param string $value
	 **/
	public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
	 * Make sure the password field is hashed
	 *
	 * @param string $value
	 **/
	public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
	 * Make sure the key field is set if it is null
	 *
	 * @param string $value
	 **/
    public function getKeyAttribute($value)
    {
        if(is_null($value))
            return $this->setKey();

        return $value;
    }

	/**
	 * Update user password
	 *
	 * @param string $password
	 **/
	public function setPassword($password) {
		$this->password = bcrypt($password);
		$this->save();
	}

	/**
	 * Update user key
	 *
	 **/
	public function setKey() {
		$key = str_random(32);
		$this->key = $key;
		$this->save();
		return $key;
	}

}
