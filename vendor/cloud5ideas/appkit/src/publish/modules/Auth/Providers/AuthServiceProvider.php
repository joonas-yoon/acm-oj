<?php
namespace App\Modules\Auth\Providers;

use App;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * Register the Auth module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Auth\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Auth module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('auth', __DIR__.'/../Resources/Lang/');

		View::addNamespace('auth', __DIR__.'/../Resources/Views/');
	}
}
