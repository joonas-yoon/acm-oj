<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\ResultRepository,
    App\Repositories\StatisticsRepository,
    App\Repositories\UserStatisticsRepository,
    App\Repositories\ProblemStatisticsRepository,
    App\Repositories\ProblemRepository,
    App\Repositories\UserRepository;

use App\Models\Result,
    App\Models\Statistics,
    App\Models\UserStatistics,
    App\Models\ProblemStatistics,
    App\Models\Problem,
    App\Models\User;

use App\Services\StatisticsService;

class StatisticsServiceProvider extends ServiceProvider
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
        $this->registerStatistics();
        $this->registerUserStatistics();
        $this->registerProblemStatistics();
        $this->registerProblem();
        $this->registerUser();
        $this->registerResult();
        $this->registerStatisticsService();
    }
    
    public function registerStatistics()
    {
        $this->app->singleton('StatisticsRepository', function ($app) {
            $model = new Statistics;
            return new StatisticsRepository($model);
        });
    }
    
    public function registerUserStatistics()
    {
        $this->app->singleton('UserStatisticsRepository', function ($app) {
            $model = new UserStatistics;
            return new UserStatisticsRepository($model);
        });
    }
    
    public function registerProblemStatistics()
    {
        $this->app->singleton('ProblemStatisticsRepository', function ($app) {
            $model = new ProblemStatistics;
            return new ProblemStatisticsRepository($model);
        });
    }
    
    public function registerProblem()
    {
        $this->app->singleton('ProblemRepository', function ($app) {
            $model = new Problem;
            return new ProblemRepository($model);
        });
    }
    
    public function registerUser()
    {
        $this->app->singleton('UserRepository', function ($app) {
            $model = new User;
            return new UserRepository($model);
        });
    }
    
    public function registerResult()
    {
        $this->app->singleton('ResultRepository', function ($app) {
            $model = new Result;
            return new ResultRepository($model);
        });
    }
    
    public function registerStatisticsService()
    {
        $this->app->singleton('StatisticsService', function ($app) {
            $statisticsService = new StatisticsService(
                $app['StatisticsRepository'],
                $app['UserStatisticsRepository'],
                $app['ProblemStatisticsRepository'],
                $app['ProblemRepository'],
                $app['UserRepository'],
                $app['ResultRepository']
            );
            
            return $statisticsService;
        });
    }

    protected $defer = true;
    
    public function provides()
    {
        return [
            'StatisticsRepository',
            'UserStatisticsRepository',
            'ProblemStatisticsRepository',
            'ProblemRepository',
            'UserRepository',
            'ResultRepository'
        ];
    }
}
