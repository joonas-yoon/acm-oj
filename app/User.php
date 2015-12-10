<?php
namespace App;

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
        'photo_path'
    ];
    
    protected $loginNames = ['name', 'email'];
    
    protected $profiles = ['via', 'first_name', 'last_name', 'email_open', 'organization', 'photo_path'];

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
    
    public function statistics() {
        return $this->hasMany('App\Statistics');
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
        Statistics::firstOrCreate([
            'user_id' => $this->id,
            'problem_id' => $problem_id,
            'result_id' => Result::getAcceptCode()
        ]);
        $this->increment('total_submit');
        Problem::find($problem_id)->increment('total_submit');
    }

    public function getTotalRate() {
        $submitCnt = $this->getSubmitCount();
        return $submitCnt > 0 ? 100 * $this->getAcceptCount() / $submitCnt : 0;
    }
    
    public function getAcceptProblems() {
        return $this->statistics()->where('result_id', Result::getAcceptCode())
            ->where('count', '>', 0)->orderBy('problem_id')
            ->with(['problems' => function($query) {
                $query->select('id', 'title');
            }])->get();
    }
    
    public function getTriedProblems() {
        return $this->statistics()->where('result_id', Result::getAcceptCode())
            ->where('count', 0)->orderBy('problem_id')
            ->with(['problems' => function($query) {
                $query->select('id', 'title');
            }])->get();
    }
    
    public function userStatistics() {
        return $this->hasMany('App\UserStatistics');
    }
    
    public function getResultCount($result_id) {
        return Statistics::getCountOrZero($this->userStatistics()->where('result_id', $result_id)->first());
    }
    
    public function updateProfile(array $profiles) {
        $profiles = array_only($profiles, $this->profiles);
        return $this->update($profiles);
    }
}
