<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\SolutionRepository,
    App\Repositories\UserRepository,
    App\Repositories\CodeRepository,
    App\Repositories\ResultRepository;
    
use App\Models\Solution,
    App\Models\User,
    App\Models\Code,
    App\Models\Result;

use App\Services\StatisticsService,
    App\Services\SolutionService;
    
use App\Services\Protects\SolutionServiceProtected;

class SolutionServiceProvider extends ServiceProvider
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
        $this->registerSolutionService();
    }
    
    public function registerSolutionService()
    {
        $this->registerSolutionServiceProtected();
        
        $this->app->singleton('SolutionService', function ($app) {
            return new SolutionService($app['SolutionServiceProtected']);
        });
    }

    public function registerSolutionServiceProtected()
    {
        $this->registerSolution();
        $this->registerUser();
        $this->registerCode();
        $this->registerResult();
        
        $this->app->singleton('SolutionServiceProtected', function ($app) {
            return new SolutionServiceProtected(
                $app['SolutionRepository'],
                $app['UserRepository'],
                $app['CodeRepository'],
                $app['ResultRepository'],
                $app['StatisticsService']
            );
        });
    }
    
    public function registerSolution()
    {
        $this->app->singleton('SolutionRepository', function ($app) {
            $model = new Solution;
            return new SolutionRepository($model);
        });
    }
    
    public function registerUser()
    {
        $this->app->singleton('UserRepository', function ($app) {
            $model = new User;
            return new UserRepository($model);
        });
    }
    
    public function registerCode()
    {
        $this->app->singleton('CodeRepository', function ($app) {
            $model = new Code;
            return new CodeRepository($model);
        });
    }
    
    public function registerResult()
    {
        $this->app->singleton('ResultRepository', function ($app) {
            $model = new Result;
            return new ResultRepository($model);
        });
    }

    protected $defer = true;
    
    public function provides()
    {
        return [
            'SolutionRepository',
            'UserRepository',
            'CodeRepository',
            'ProblemRepository',
            'ResultRepository',
            'StatisticsService',
            'SolutionServiceProtected',
            'SolutionService'
        ];
    }
}

