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

use App\Services\Protects\ProblemServiceProtected;

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
        $this->registerProblemService();
    }
    
    public function registerProblemService()
    {
        $this->registerProblemServiceProtected();
        
        $this->app->singleton('ProblemService', function ($app) {
            return new ProblemService(
                $app['ProblemServiceProtected']
            );
        });
    }

    public function registerProblemServiceProtected()
    {
        $this->registerProblem();
        $this->registerThank();
        $this->registerProblemThank();
        $this->registerProblemTag();
        
        $this->app->singleton('ProblemServiceProtected', function ($app) {
            return new ProblemServiceProtected(
                $app['ProblemRepository'],
                $app['ThankRepository'],
                $app['ProblemThankRepository'],
                $app['ProblemTagRepository']
            );
        });
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
    
    protected $defer = true;
    
    public function provides()
    {
        return [
            'ProblemRepository',
            'ThankRepository',
            'ProblemThankRepository',
            'ProblemTagRepository',
            'ProblemServiceProtected',
            'ProblemService'
        ];
    }
    

}
