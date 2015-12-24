<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\PostRepository;
    
use App\Models\Post;

use App\Services\PostService;

use App\Services\Protects\PostServiceProtected;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPostService();
    }
    
    public function registerPostService()
    {
        $this->registerPostServiceProtected();
        
        $this->app->singleton('PostService', function ($app) {
            return new PostService($app['PostServiceProtected']);
        });
    }

    public function registerPostServiceProtected()
    {
        $this->registerPost();
        
        $this->app->singleton('PostServiceProtected', function ($app) {
            return new PostServiceProtected(
                $app['PostRepository'],
                $app['UserRepository'],
                $app['ProblemRepository']
            );
        });
    }

    public function registerPost()
    {
        $this->app->singleton('PostRepository', function ($app) {
            $model = new Post;
            return new PostRepository($model);
        });
    }

    protected $defer = true;
    
    public function provides()
    {
        return [
            'PostRepository',
            'PostServiceProtected',
            'PostService'
        ];
    }
}
