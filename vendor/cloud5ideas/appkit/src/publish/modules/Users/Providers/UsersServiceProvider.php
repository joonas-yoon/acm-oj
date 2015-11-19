<?php
namespace App\Modules\Users\Providers;

use App;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
	/**
	 * Register the Users module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Users\Providers\RouteServiceProvider');
		view()->composer('users::*', 'App\Modules\Users\Composers\UsersPermissionsComposer');

		$this->registerNamespaces();
	}

	/**
	 * Register the Users module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('users', __DIR__.'/../Resources/Lang/');

		View::addNamespace('users', __DIR__.'/../Resources/Views/');
	}
}
