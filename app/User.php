<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    /*AuthorizableContract,*/
                                    CanResetPasswordContract
{
    use Authenticatable, /*Authorizable,*/ CanResetPassword;

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
    protected $fillable = ['name', 'email', 'password', 'total_submit', 'total_clear'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Find by username, or throw an exception.
     *
     * @param string $username The username.
     * @param mixed $columns The columns to return.
     *
     * @throws ModelNotFoundException if no matching User exists.
     *
     * @return User
     */
    public static function findByNameOrFail(
        $name,
        $columns = array('*')
    ) {
        if ( ! is_null($user = static::whereName($name)->first($columns))) {
            return $user;
        }

        throw new ModelNotFoundException;
    }
    public static function findByNameOrEmailOrFail(
        $nameOrEmail,
        $columns = array('*')
    ) {
        if ( ! is_null($user = static::whereName($nameOrEmail)->orWhere('email', $nameOrEmail)->first($columns))) {
            return $user;
        }

        throw new ModelNotFoundException;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles() {
        return $this->hasMany('App\Article');
    }

    public function solutions() {
        return $this->hasMany('App\Solution')->has('problem');
    }
    public function contributeProblems() {
        return $this->hasMany('App\Problem');
    }

    public function getAcceptCount() {
        return $this->total_clear;
    }
    public function getSubmitCount() {
        return $this->total_submit;
    }

    public function addSubmit($problem_id) {
        $this->increment('total_submit');
        Problem::find($problem_id)->increment('total_submit');
    }

    public function getRate() {
        $submitCnt = $this->getSubmitCount();
        return $submitCnt > 0 ? 100 * $this->getAcceptCount() / $submitCnt : 0;
    }
}
