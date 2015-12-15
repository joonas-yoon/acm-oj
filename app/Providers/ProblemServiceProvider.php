<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\ProblemRepository,
    App\Repositories\ThankRepository,
    App\Repositories\ProblemThankRepository,
    App\Repositories\ProblemTagRepository;

use App\Models\Problem,
    App\Models\ProblemThank,
    App\Models\ProblemTag,
    App\Models\Thank;

use App\Services\ProblemService;

class ProblemServiceProvider extends ServiceProvider
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
        $this->registerProblem();
        $this->registerThank();
        $this->registerProblemThank();
        $this->registerProblemTag();
        $this->registerProblemService();
    }
    
    public function registerProblem()
    {
        $this->app->singleton('ProblemRepository', function ($app) {
            $model = new Problem;
            return new ProblemRepository($model);
        });
    }
    
    public function registerThank()
    {
        $this->app->singleton('ThankRepository', function ($app) {
            $model = new Thank;
            return new ThankRepository($model);
        });
    }
    
    public function registerProblemThank()
    {
        $this->app->singleton('ProblemThankRepository', function ($app) {
            $model = new ProblemThank;
            return new ProblemThankRepository($model);
        });
    }
    
    public function registerProblemTag()
    {
        $this->app->singleton('ProblemTagRepository', function ($app) {
            $model = new ProblemTag;
            return new ProblemTagRepository($model);
        });
    }
    
    public function registerProblemService()
    {
        $this->app->singleton('ProblemService', function ($app) {
            $problemService = new ProblemService(
                $app['ProblemRepository'],
                $app['ThankRepository'],
                $app['ProblemThankRepository'],
                $app['ProblemTagRepository']
            );
            
            return $problemService;
        });
    }
    
    protected $defer = true;
    
    public function provides()
    {
        return [
            'ProblemRepository',
            'ThankRepository',
            'ProblemThankRepository',
            'ProblemTagRepository',
            'ProblemService'
        ];
    }
    

}
