<?php
namespace App\Modules\Shell\Providers;

use App;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class ShellServiceProvider extends ServiceProvider
{
	/**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting.
     *
     * @return void
     */
    public function boot()
    {
    	view()->composers([
    		'App\Modules\Shell\Composers\NavigationComposer' => 'shell::components.navigation.menu',
    		'App\Modules\Shell\Composers\UserComposer' => '*'
    	]);
    }

	/**
	 * Register the Shell module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Shell\Providers\RouteServiceProvider');
		$this->registerNamespaces();
	}

	/**
	 * Register the Shell module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('shell', __DIR__.'/../Resources/Lang/');

		View::addNamespace('shell', __DIR__.'/../Resources/Views/');
	}
}
