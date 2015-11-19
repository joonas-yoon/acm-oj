<?php namespace C5\AppKit;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Support\ServiceProvider;
use C5\AppKit\Modules\Modules;
use C5\AppKit\Menus\Menu;
use C5\AppKit\JavaScript\PHPToJavaScriptTransformer;
use C5\AppKit\JavaScript\LaravelViewBinder;
use C5\AppKit\Exceptions\JavaScriptException;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class AppKitServiceProvider extends ServiceProvider
{
	/**
	 * @var bool $defer Indicates if loading of the provider is deferred.
	 */
	protected $defer = false;

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__ . '/../views', 'appkit');

		$this->publishes([
			__DIR__.'/../publish/config/appkit.php' => config_path('appkit.php')
		], 'config');

		$this->publishes([
			__DIR__.'/../publish/database' => $this->app->databasePath()
		], 'database');

		$this->publishes([
			__DIR__.'/../publish/models' => app_path()
		], 'models');

		$this->publishes([
			__DIR__.'/../publish/views' => base_path('resources/views'),
			__DIR__.'/../views' => base_path('resources/views/vendor/appkit')
		], 'views');

		$this->publishes([
			__DIR__.'/../publish/modules' => app_path('Modules')
		], 'modules');

		$this->publishes([
			__DIR__.'/../publish/assets/less' => base_path('resources/assets/less')
		], 'less');

		$this->publishes([
			__DIR__.'/../publish/assets/sass' => base_path('resources/assets/sass')
		], 'sass');

		$this->publishes([
			__DIR__.'/../publish/assets/coffee' => base_path('resources/assets/coffee')
		], 'coffee');

		$this->publishes([
			__DIR__.'/../publish/public' => base_path('public')
		], 'public');

		$this->publishes([
			__DIR__.'/../publish/http' => app_path('Http')
		], 'http');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../publish/config/appkit.php', 'appkit'
		);

		$this->registerAliases();

		$this->registerServices();

		$this->registerRepository();

		// Once we have registered the migrator instance we will go ahead and register
		// all of the migration related commands that are used by the "Artisan" CLI
		// so that they may be easily accessed for registering with the consoles.
		$this->registerMigrator();

		$this->registerConsoleCommands();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string
	 */
	public function provides()
	{
		return ['modules', 'menu', 'flash', 'form', 'html'];
	}

	/**
	 * Register the AppKit aliases / facades.
	 *
	 * @return void
	 */
	protected function registerAliases() {

		$aliases = AliasLoader::getInstance();
		$aliases->alias(
            'Form',
            'Illuminate\Html\FormFacade'
        );
        $aliases->alias(
            'Html',
            'Illuminate\Html\HtmlFacade'
        );
		$aliases->alias(
            'Modules',
            'C5\AppKit\Facades\ModulesFacade'
        );
        $aliases->alias(
            'Menu',
            'C5\AppKit\Facades\MenuFacade'
        );
        $aliases->alias(
            'Flash',
            'C5\AppKit\Facades\FlashFacade'
        );
        $aliases->alias(
            'JavaScript',
            'C5\AppKit\Facades\JavaScriptFacade'
        );
	}

	/**
	 * Register the package services.
	 *
	 * @return void
	 */
	protected function registerServices()
	{

		$this->app->register('Illuminate\Html\HtmlServiceProvider');

		$this->app->bindShared('modules', function ($app) {
			return new Modules($app['config'], $app['files']);
		});

		$this->app->bindShared('menu', function($app) {
			return new Menu($app['config'], $app['view'], $app['html'], $app['url']);
		});

		$this->app->bind(
            'C5\AppKit\Flash\FlashSessionStore',
            'C5\AppKit\Flash\LaravelSessionStore'
        );

		$this->app->bindShared('flash', function () {
            return $this->app->make('C5\AppKit\Flash\FlashNotifier');
        });

		$this->app->bind('JavaScript', function ($app) {
            $view = config('appkit.bind_js_vars_to_this_view');
            $namespace = config('appkit.js_namespace');

            if (is_null($view)) {
                throw new JavaScriptException;
            }

            $binder = new LaravelViewBinder($app['events'], $view);

            return new PHPToJavaScriptTransformer($binder, $namespace);
        });

		$this->app->booting(function ($app) {
			$app['modules']->register();
		});
	}

	/**
	 * Register the migration repository service.
	 *
	 * @return void
	 */
	protected function registerRepository()
	{
		$this->app->singleton('migration.repository', function($app)
		{
			$table = $app['config']['database.migrations'];

			return new DatabaseMigrationRepository($app['db'], $table);
		});
	}

	/**
	 * Register the migrator service.
	 *
	 * @return void
	 */
	protected function registerMigrator()
	{
		// The migrator is responsible for actually running and rollback the migration
		// files in the application. We'll pass in our database connection resolver
		// so the migrator can resolve any of these connections when it needs to.
		$this->app->singleton('migrator', function($app)
		{
			$repository = $app['migration.repository'];

			return new Migrator($repository, $app['db'], $app['files']);
		});
	}

	/**
	 * Register the package console commands.
	 *
	 * @return void
	 */
	protected function registerConsoleCommands()
	{
		$this->registerInitCommand();
		$this->registerInstallCommand();
		$this->registerPublishCommand();
		$this->registerMigrateCommand();
		$this->registerMigrateRefreshCommand();
		$this->registerMigrateRollbackCommand();
		$this->registerMigrateResetCommand();
		$this->registerSeedCommand();
		$this->registerFakeUsersCommand();
		$this->registerMakeModuleCommand();
		$this->registerEnableModuleCommand();
		$this->registerDisableModuleCommand();
		$this->registerMakeModuleMigrationCommand();
		$this->registerMakeModuleRequestCommand();
		$this->registerMakeModuleControllerCommand();
		$this->registerMakeModuleSeederCommand();
		$this->registerMakeModuleEmailCommand();
		$this->registerMigrateModuleCommand();
		$this->registerMigrateRefreshModuleCommand();
		$this->registerMigrateResetModuleCommand();
		$this->registerMigrateRollbackModuleCommand();
		$this->registerSeedModuleCommand();
		$this->registerListModulesCommand();

		$this->commands([
			'appkit.init',
			'appkit.install',
			'appkit.publish',
			'appkit.migrate',
			'appkit.migrate.refresh',
			'appkit.migrate.rollback',
			'appkit.migrate.reset',
			'appkit.seed',
			'appkit.fake.users',
			'appkit.make.module',
			'appkit.enable.module',
			'appkit.disable.module',
			'appkit.make.module.migration',
			'appkit.make.module.request',
			'appkit.make.module.controller',
			'appkit.make.module.seeder',
			'appkit.make.module.email',
			'appkit.migrate.module',
			'appkit.migrate.refresh.module',
			'appkit.migrate.reset.module',
			'appkit.migrate.rollback.module',
			'appkit.seed.module',
			'appkit.list.modules'
		]);
	}

	/**
	 * Register the "appkit:init" console command.
	 *
	 * @return Console\Core\InitCommand
	 */
	protected function registerInitCommand()
	{
		$this->app->bindShared('appkit.init', function($app) {
			$handler = new Handlers\Core\InitHandler($app['files']);

			return new Console\Core\InitCommand($handler);
		});
	}

	/**
	 * Register the "appkit:install" console command.
	 *
	 * @return Console\Core\InstallCommand
	 */
	protected function registerInstallCommand()
	{
		$this->app->bindShared('appkit.install', function($app) {
			$handler = new Handlers\Core\InstallHandler();

			return new Console\Core\InstallCommand($handler);
		});
	}

	/**
	 * Register the "appkit:publish" console command.
	 *
	 * @return Console\Core\PublishCommand
	 */
	protected function registerPublishCommand()
	{
		$this->app->bindShared('appkit.publish', function() {
			return new Console\Core\PublishCommand;
		});
	}

	/**
	 * Register the "appkit:migrate" console command.
	 *
	 * @return Console\Core\MigrateCommand
	 */
	protected function registerMigrateCommand()
	{
		$this->app->bindShared('appkit.migrate', function($app) {
			$handler = new Handlers\Core\MigrateHandler();

			return new Console\Core\MigrateCommand($handler);
		});
	}

	/**
	 * Register the "appkit:migrate:refresh" console command.
	 *
	 * @return Console\Core\MigrateRefresCommand
	 */
	protected function registerMigrateRefreshCommand()
	{
		$this->app->bindShared('appkit.migrate.refresh', function($app) {
			$handler = new Handlers\Core\MigrateHandler();

			return new Console\Core\MigrateRefreshCommand($handler);
		});	}

	/**
	 * Register the "appkit:migrate:rollback" console command.
	 *
	 * @return Console\Core\MigrateRollbackCommand
	 */
	protected function registerMigrateRollbackCommand()
	{
		$this->app->bindShared('appkit.migrate.rollback', function($app) {
			$handler = new Handlers\Core\MigrateHandler();

			return new Console\Core\MigrateRollbackCommand($handler);
		});
	}

	/**
	 * Register the "appkit:migrate:reset" console command.
	 *
	 * @return Console\Core\MigrateResetCommand
	 */
	protected function registerMigrateResetCommand()
	{
		$this->app->bindShared('appkit.migrate.reset', function($app) {
			$handler = new Handlers\Core\MigrateHandler();

			return new Console\Core\MigrateResetCommand($handler);
		});
	}

	/**
	 * Register the "appkit:seed" console command.
	 *
	 * @return Console\Core\SeedCommand
	 */
	protected function registerSeedCommand()
	{
		$this->app->bindShared('appkit.seed', function() {
			return new Console\Core\SeedCommand;
		});
	}

	/**
	 * Register the "appkit:fake:users" console command.
	 *
	 * @return Console\Core\PublishCommand
	 */
	protected function registerFakeUsersCommand()
	{
		$this->app->bindShared('appkit.fake.users', function() {
			return new Console\Core\SeedFakeUsersCommand;
		});
	}

	/**
	 * Register the "appkit:enable:module" console command.
	 *
	 * @return Console\Modules\ModuleEnableCommand
	 */
	protected function registerEnableModuleCommand()
	{
		$this->app->bindShared('appkit.enable.module', function() {
			return new Console\Modules\EnableModuleCommand;
		});
	}

	/**
	 * Register the "appkit:disable:module" console command.
	 *
	 * @return Console\Modules\ModuleDisableCommand
	 */
	protected function registerDisableModuleCommand()
	{
		$this->app->bindShared('appkit.disable.module', function() {
			return new Console\Modules\DisableModuleCommand;
		});
	}

	/**
	 * Register the "appkit:make:module" console command.
	 *
	 * @return Console\Modules\ModuleMakeCommand
	 */
	protected function registerMakeModuleCommand()
	{
		$this->app->bindShared('appkit.make.module', function($app) {
			$handler = new Handlers\Modules\MakeModuleHandler($app['modules'], $app['files']);

			return new Console\Modules\MakeModuleCommand($handler);
		});
	}

	/**
	 * Register the "appkit:make:module:migration" console command.
	 *
	 * @return Console\Modules\ModuleMakeMigrationCommand
	 */
	protected function registerMakeModuleMigrationCommand()
	{
		$this->app->bindShared('appkit.make.module.migration', function($app) {
			$handler = new Handlers\Modules\MakeModuleMigrationHandler($app['modules'], $app['files']);

			return new Console\Modules\MakeModuleMigrationCommand($handler);
		});
	}

	/**
	 * Register the "appkit:make:module:request" console command.
	 *
	 * @return Console\Modules\ModuleMakeRequestCommand
	 */
	protected function registerMakeModuleRequestCommand()
	{
		$this->app->bindShared('appkit.make.module.request', function($app) {
			$handler = new Handlers\Modules\MakeModuleRequestHandler($app['modules'], $app['files']);

			return new Console\Modules\MakeModuleRequestCommand($handler);
		});
	}

	/**
	 * Register the "appkit:make:module:controller" console command.
	 *
	 * @return Console\Modules\ModuleMakeControllerCommand
	 */
	protected function registerMakeModuleControllerCommand()
	{
		$this->app->bindShared('appkit.make.module.controller', function($app) {
			$handler = new Handlers\Modules\MakeModuleControllerHandler($app['modules'], $app['files']);

			return new Console\Modules\MakeModuleControllerCommand($handler);
		});
	}

	/**
	 * Register the "appkit:make:module:seeder" console command.
	 *
	 * @return Console\Modules\ModuleMakeSeederCommand
	 */
	protected function registerMakeModuleSeederCommand()
	{
		$this->app->bindShared('appkit.make.module.seeder', function($app) {
			$handler = new Handlers\Modules\MakeModuleSeederHandler($app['modules'], $app['files']);

			return new Console\Modules\MakeModuleSeederCommand($handler);
		});
	}

	/**
	 * Register the "appkit:make:module:email" console command.
	 *
	 * @return Console\Modules\ModuleMakeEmailCommand
	 */
	protected function registerMakeModuleEmailCommand()
	{
		$this->app->bindShared('appkit.make.module.email', function($app) {
			$handler = new Handlers\Modules\MakeModuleEmailHandler($app['modules'], $app['files']);

			return new Console\Modules\MakeModuleEmailCommand($handler);
		});
	}

	/**
	 * Register the "appkit:migrate:module" console command.
	 *
	 * @return Console\Modules\ModuleMigrateCommand
	 */
	protected function registerMigrateModuleCommand()
	{
		$this->app->bindShared('appkit.migrate.module', function($app) {
			return new Console\Modules\MigrateModuleCommand($app['migrator'], $app['modules']);
		});
	}

	/**
	 * Register the "appkit:migrate:refresh:module" console command.
	 *
	 * @return Console\Modules\ModuleMigrateRefreshCommand
	 */
	protected function registerMigrateRefreshModuleCommand()
	{
		$this->app->bindShared('appkit.migrate.refresh.module', function() {
			return new Console\Modules\MigrateRefreshModuleCommand;
		});
	}

	/**
	 * Register the "appkit:migrate:reset:module" console command.
	 *
	 * @return Console\Modules\ModuleMigrateResetCommand
	 */
	protected function registerMigrateResetModuleCommand()
	{
		$this->app->bindShared('appkit.migrate.reset.module', function($app) {
			return new Console\Modules\MigrateResetModuleCommand($app['modules'], $app['files'], $app['migrator']);
		});
	}

	/**
	 * Register the "appkit:migrate:rollback:module" console command.
	 *
	 * @return Console\Modules\ModuleMigrateRollbackCommand
	 */
	protected function registerMigrateRollbackModuleCommand()
	{
		$this->app->bindShared('appkit.migrate.rollback.module', function($app) {
			return new Console\Modules\MigrateRollbackModuleCommand($app['modules']);
		});
	}

	/**
	 * Register the "appkit:seed:module" console command.
	 *
	 * @return Console\Modules\ModuleSeedCommand
	 */
	protected function registerSeedModuleCommand()
	{
		$this->app->bindShared('appkit.seed.module', function($app) {
			return new Console\Modules\SeedModuleCommand($app['modules']);
		});
	}

	/**
	 * Register the "appkit:list:modules" console command.
	 *
	 * @return Console\Modules\ModuleListCommand
	 */
	protected function registerListModulesCommand()
	{
		$this->app->bindShared('appkit.list.modules', function($app) {
			return new Console\Modules\ListModulesCommand($app['modules']);
		});
	}
}
