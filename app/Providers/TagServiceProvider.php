<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\TagRepository,
    App\Repositories\UserTagRepository,
    App\Repositories\ProblemTagRepository;

use App\Models\Tag,
    App\Models\UserTag,
    App\Models\ProblemTag;

use App\Services\TagService;

use App\Services\Protects\TagServiceProtected;

class TagServiceProvider extends ServiceProvider
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
        $this->registerTagService();
    }
    
    public function registerTagService()
    {
        $this->registerTagServiceProtected();
        
        $this->app->singleton('TagService', function ($app) {
            return new TagService($app['TagServiceProtected']);
        });
    }

    public function registerTagServiceProtected()
    {
        $this->registerTag();
        $this->registerUserTag();
        $this->registerProblemTag();
        
        $this->app->singleton('TagServiceProtected', function ($app) {
            return new TagServiceProtected(
                $app['TagRepository'],
                $app['UserTagRepository'],
                $app['ProblemTagRepository']
            );
        });
    }
    
    public function registerTag()
    {
        $this->app->singleton('TagRepository', function ($app) {
            $model = new Tag;
            return new TagRepository($model);
        });
    }
    
    public function registerUserTag()
    {
        $this->app->singleton('UserTagRepository', function ($app) {
            $model = new UserTag;
            return new UserTagRepository($model);
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
            'TagRepository',
            'UserTagRepository',
            'ProblemTagRepository',
            'TagServiceProtected',
            'TagService'
        ];
    }
}
