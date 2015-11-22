<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Model implements AuthenticatableContract,
                                    /*AuthorizableContract,*/
                                    CanResetPasswordContract,
                                    HasRoleAndPermissionContract
{
    use Authenticatable, /*Authorizable,*/ CanResetPassword;
    use HasRoleAndPermission;

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
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles() {
        return $this->hasMany('App\Article');
    }

    public function solutions() {
        return $this->hasMany('App\Solution');
    }
    public function solutions_accept() {
        return $this->solutions->where('result_id', 2);
    }

    public function contributeProblems() {
        return $this->hasMany('App\Problem');
    }

    public function getSubmitCount() {
        return $this->solutions->count();
    }
    public function getRate() {
        $submitCnt = $this->getSubmitCount();
        return $submitCnt > 0 ?
                100 * $this->solutions_accept()->count() / $this->getSubmitCount()
                : 0;
    }
}
