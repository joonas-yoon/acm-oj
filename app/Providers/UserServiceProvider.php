<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\UserRepository;
    
use App\Models\User;

use App\Services\UserService;

use App\Services\Protects\UserServiceProtected;

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
        $this->registerUserService();
    }
    
    public function registerUserService()
    {
        $this->registerUserServiceProtected();
        
        $this->app->singleton('UserService', function ($app) {
            return new UserService($app['UserServiceProtected']);
        });
    }

    public function registerUserServiceProtected()
    {
        $this->registerUser();
        
        $this->app->singleton('UserServiceProtected', function ($app) {
            return new UserServiceProtected(
                $app['UserRepository']
            );
        });
    }

    public function registerUser()
    {
        $this->app->singleton('UserRepository', function ($app) {
            $model = new User;
            return new UserRepository($model);
        });
    }

    protected $defer = true;
    
    public function provides()
    {
        return [
            'UserRepository',
            'UserServiceProtected',
            'UserService'
        ];
    }
}
