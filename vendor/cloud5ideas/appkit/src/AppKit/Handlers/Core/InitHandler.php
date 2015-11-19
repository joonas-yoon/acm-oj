<?php namespace C5\AppKit\Handlers\Core;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class InitHandler
{
	/**
	 * @var Console
	 */
	protected $console;

	/**
	 * @var array $folders Folders to be deleted.
	 */
	protected $folders = [
		'app/Http/Controllers/Auth',
		'resources/views/auth'
	];

	/**
	 * @var array $files Files to be deleted.
	 */
	protected $files = [
		'resources/views/app.blade.php',
		'resources/views/home.blade.php',
		'resources/views/welcome.blade.php',
		'resources/views/emails/password.blade.php',
		'app/User.php',
		'app/Http/Controllers/HomeController.php',
		'database/seeds/DatabaseSeeder.php'
	];

	/**
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $finder;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $assets;

	/**
	 * Constructor method.
	 *
	 */
	public function __construct(Filesystem $finder)
	{
		$this->finder  = $finder;
	}

	/**
	 * Fire off the handler.
	 *
	 * @param  \C5\AppKit\Console\InitCommand $console
	 * @param  string $name
	 * @return bool
	 */
	public function fire(Command $console, $name, $assets)
	{
		$this->console = $console;
		$this->name = $name;
		$this->assets = $assets;
		$this->init($console);
	}

	/**
	 * Initialize.
	 *
	 * @param  \C5\AppKit\Console\InitCommand $console
	 * @return boolean
	 */
	public function init(Command $console)
	{
		$this->deleteHttpFiles();
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'http']);

		$this->deleteDefaultFiles();
		$this->deleteDefaultFolders();

		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'config']);
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'database']);
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'models']);
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'views']);
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'modules']);
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => $this->assets]);
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'coffee']);
		$console->callsilent('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => 'public']);

		$this->updateConfig($this->name);

		$this->updateGulpFile($this->assets);

		exec('composer dump-autoload');
		exec('gulp');

		$console->info('AppKit [ '.$this->name.' ] has been initialized.');

		return true;
	}

	/**
	 * Delete default http files.
	 *
	 * @return void
	 */
	protected function deleteHttpFiles()
	{
		$this->finder->delete(app_path('Http/routes.php'));
		$this->finder->delete(app_path('Http/Kernel.php'));
	}

	/**
	 * Delete some default folders.
	 *
	 * @return void
	 */
	protected function deleteDefaultFolders()
	{
		foreach ($this->folders as $folder) {
			$this->finder->deleteDirectory(base_path($folder));
		}
	}

	/**
	 * Delete some default files.
	 *
	 * @return void
	 */
	protected function deleteDefaultFiles()
	{
		foreach ($this->files as $key => $file) {

			$this->finder->delete(base_path($key), $file);
		}

		$this->finder->delete($this->finder->glob(base_path('database/migrations/*create_users_table.php')));
		$this->finder->delete($this->finder->glob(base_path('database/migrations/*create_password_resets_table.php')));
	}

	/**
	 * Update config file.
	 *
	 * @return Void
	 */
	protected function updateConfig($appName)
	{
		$content = $this->finder->get(__DIR__.'/../../../publish/config/appkit.php');
		$content = str_replace(
			'{{name}}',
			studly_case($appName),
			$content
		);
		$this->finder->put(base_path('config/appkit.php'), $content);
	}

	/**
	 * Update the gulp file.
	 *
	 * @return Void
	 */
	protected function updateGulpFile($assets)
	{
		$content = $this->finder->get(__DIR__.'/../../../publish/gulp/gulpfile.'.$assets.'.js');
		$this->finder->put(base_path('gulpfile.js'), $content);
	}
}
