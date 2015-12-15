<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\UserRepository;
    
use App\Models\User;

use App\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerUser();
        $this->registerUserService();
    }
    
    public function registerUser()
    {
        $this->app->singleton('UserRepository', function ($app) {
            $model = new User;
            return new UserRepository($model);
        });
    }
    
    public function registerUserService()
    {
        $this->app->singleton('UserService', function ($app) {
            $userService = new UserService(
                $app['UserRepository']
            );
            
            return $userService;
        });
    }
    

    protected $defer = true;
    
    public function provides()
    {
        return [
            'UserRepository',
            'UserService'
        ];
    }
}
