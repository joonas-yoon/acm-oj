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
        $this->registerTag();
        $this->registerUserTag();
        $this->registerProblemTag();
        $this->registerTagService();
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
    
    public function registerTagService()
    {
        $this->app->singleton('TagService', function ($app) {
            $tagService = new TagService(
                $app['TagRepository'],
                $app['UserTagRepository'],
                $app['ProblemTagRepository']
            );
            
            return $tagService;
        });
    }
    
    protected $defer = true;
    
    public function provides()
    {
        return [
            'TagRepository',
            'UserTagRepository',
            'ProblemTagRepository',
            'TagService'
        ];
    }
}
