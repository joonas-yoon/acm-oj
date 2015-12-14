<?php
namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Sentinel;

class User extends SentinelUser implements AuthenticatableContract,
                                        CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    
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
    protected $fillable = [
        'name',
        'email',
        'email_open',
        'password',
        'permissions',
        'total_submit',
        'total_clear',
        
        'via',
        'first_name',
        'last_name',
        'organization',
        'photo_path',
        'default_language',
        'default_code_theme'
    ];
    
    protected $loginNames = ['name', 'email'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    static public $editable = [
        'via',
        'first_name', 'last_name',
        'email_open',
        'organization',
        'photo_path',
        'default_language',
        'default_code_theme'
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function solutions()
    {
        return $this->hasMany('App\Models\Solution')->has('problem');
    }
    
    public function statisticses()
    {
        return $this->hasMany('App\Models\Statistics');
    }
    
    public function contributeProblems()
    {
        return $this->hasMany('App\Models\Problem');
    }

    public function userStatisticses()
    {
        return $this->hasMany('App\Models\UserStatistics');
    }

    public function getAcceptCount()
    {
        return $this->total_clear;
    }
    public function getSubmitCount()
    {
        return $this->total_submit;
    }

    public function getTotalRate()
    {
        $submitCnt = $this->getSubmitCount();
        return $submitCnt > 0 ? 100 * $this->getAcceptCount() / $submitCnt : 0;
    }
    
    public function getPhotoPathAttribute($photo_path) {
        $fileName = explode('/', $photo_path);
        $fileName = end($fileName);
        
        return $fileName ? "/images/profile/{$fileName}" : '';
    }
    public function getPhotoLinkAttribute() {
        return $this->photo_path ? url($this->photo_path) : url('/images/no-image.png');
    }
    
    public function scopeWhereNameOrEmail($query, $nameOrEmail)
    {
        return $query->where(function($query2) use ($nameOrEmail) {
                        $query2->where('name', $nameOrEmail)->orWhere('email', $nameOrEmail);
                     });
    }
}
