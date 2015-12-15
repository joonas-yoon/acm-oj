<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\SolutionRepository,
    App\Repositories\UserRepository,
    App\Repositories\CodeRepository,
    App\Repositories\StatisticsRepository,
    App\Repositories\ResultRepository;
    
use App\Models\Solution,
    App\Models\User,
    App\Models\Code,
    App\Models\Statistics,
    App\Models\Result;

use App\Services\StatisticsService,
    App\Services\SolutionService;

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
        $this->registerSolution();
        $this->registerUser();
        $this->registerCode();
        $this->registerStatistics();
        $this->registerResult();
        $this->registerSolutionService();
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
    
    public function registerStatistics()
    {
        $this->app->singleton('StatisticsRepository', function ($app) {
            $model = new Statistics;
            return new StatisticsRepository($model);
        });
    }
    
    public function registerResult()
    {
        $this->app->singleton('ResultRepository', function ($app) {
            $model = new Result;
            return new ResultRepository($model);
        });
    }
    
    public function registerSolutionService()
    {
        $this->app->singleton('SolutionService', function ($app) {
            $solutionService = new SolutionService(
                $app['SolutionRepository'],
                $app['UserRepository'],
                $app['CodeRepository'],
                $app['ResultRepository'],
                $app['StatisticsService']
            );
            
            return $solutionService;
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
            'StatisticsService'
        ];
    }
}

