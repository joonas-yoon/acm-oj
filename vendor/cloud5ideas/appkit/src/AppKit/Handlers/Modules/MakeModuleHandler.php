<?php namespace C5\AppKit\Handlers\Modules;

use C5\AppKit\Modules\Modules;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/modules
 */
class MakeModuleHandler
{
	/**
	 * @var Console
	 */
	protected $console;

	/**
	 * @var array $folders Module folders to be created.
	 */
	protected $folders = [
		'Console/',
		'Database/',
		'Database/Migrations/',
		'Database/Seeds',
		'Http/',
		'Http/Controllers/',
		'Http/Middleware/',
		'Http/Requests/',
		'Providers/',
		'Resources/',
		'Resources/Lang/',
		'Resources/Views/',
		'Resources/Views/Emails/',
	];

	/**
	 * @var array $blankFolders Module folders to be created for a blank module.
	 */
	protected $blankFolders = [
		'Resources/Views/Layouts/',
		'Resources/Views/Partials/',
	];

	/**
	 * @var array $files Module files to be created.
	 */
	protected $files = [
		'Database/Seeds/{{name}}DatabaseSeeder.php',
		'Database/Seeds/{{name}}PermissionsTableSeeder.php',
		'Http/Controllers/{{name}}Controller.php',
		'Http/routes.php',
		'Providers/{{name}}ServiceProvider.php',
		'Providers/RouteServiceProvider.php',
		'module.json',
		'Resources/Views/index.blade.php',
	];

	/**
	 * @var array $blankFiles Module files to be created for a blank module.
	 */
	protected $blankFiles = [
		'Resources/Views/index.blade.php',
		'Resources/Views/Layouts/{{slug}}.blade.php',
		'Resources/Views/Partials/head.blade.php'
	];

	/**
	 * @var array $stubs Module stubs used to populate defined files.
	 */
	protected $stubs = [
		'ModuleDatabaseSeeder.stub',
		'ModulePermissionsTableSeeder.stub',
		'ModuleController.stub',
		'ModuleRoutes.stub',
		'ModuleServiceProvider.stub',
		'ModuleRouteServiceProvider.stub',
		'ModuleConfig.stub',
		'ModuleViewIndex.stub',
	];

	/**
	 * @var array $blankStubs Module stubs used to populate defined files for a blank module.
	 */
	protected $blankStubs = [
		'ModuleViewIndexBlank.stub',
		'ModuleViewLayoutBlank.stub',
		'ModuleViewHeadBlank.stub'
	];

	/**
	 * @var \C5\AppKit\Modules\Modules
	 */
	protected $module;

	/**
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $finder;

	/**
	 * @var string
	 */
	protected $slug;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var boolean
	 */
	protected $blank;

	/**
	 * Constructor method.
	 *
	 * @param \C5\AppKit\Modules\Modules     $module
	 * @param \Illuminate\Filesystem\Filesystem $finder
	 */
	public function __construct(Modules $module, Filesystem $finder)
	{
		$this->module = $module;
		$this->finder  = $finder;
	}

	/**
	 * Fire off the handler.
	 *
	 * @param  \C5\AppKit\Console\ModuleMakeCommand $console
	 * @param  string                                         $slug
	 * @return bool
	 */
	public function fire(Command $console, $slug, $blank = false)
	{
		$this->console 	= $console;
		$this->slug    	= $slug;
		$this->name    	= strtolower($slug);
		$this->blank 	= $blank;

		if ($this->module->exists($this->slug)) {
			$console->comment('Module [{$this->name}] already exists.');

			return false;
		}

		$this->generate($console);
	}

	/**
	 * Generate module folders and files.
	 *
	 * @param  \C5\AppKit\Console\ModuleMakeCommand $console
	 * @return boolean
	 */
	public function generate(Command $console)
	{
		
		$this->generateFolders();

		$this->generateFiles();

		$console->info("Module [{$this->name}] has been created successfully.");

		return true;
	}

	/**
	 * Generate defined module folders.
	 *
	 * @return void
	 */
	protected function generateFolders()
	{
		if (! $this->finder->isDirectory($this->module->getPath())) {
			$this->finder->makeDirectory($this->module->getPath());
		}

		$this->finder->makeDirectory($this->getModulePath($this->slug, true));

		foreach ($this->folders as $folder) {
			$this->finder->makeDirectory($this->getModulePath($this->slug).$folder);
		}

		if( $this->blank ) {
			foreach ($this->blankFolders as $folder) {
				$this->finder->makeDirectory($this->getModulePath($this->slug).$folder);
			}
		}
	}

	/**
	 * Generate defined module files.
	 *
	 * @return void
	 */
	protected function generateFiles()
	{
		foreach ($this->files as $key => $file) {
			$file = $this->formatContent($file);
			$this->makeFile($key, $file);
		}

		if( $this->blank ) {
			foreach ($this->blankFiles as $key => $file) {
				$file = $this->formatContent($file);
				$this->makeFile($key, $file, true);
			}
		}

	}

	/**
	 * Create module file.
	 *
	 * @param  int     $key
	 * @param  string  $file
	 * @return int
	 */
	protected function makeFile($key, $file, $blank = false)
	{
		return $this->finder->put($this->getDestinationFile($file), $this->getStubContent($key, $blank));
	}

	/**
	 * Get the path to the module.
	 *
	 * @param  string $slug
	 * @return string
	 */
	protected function getModulePath($slug = null, $allowNotExists = false)
	{
		if ($slug)
			return $this->module->getModulePath($slug, $allowNotExists);

		return $this->module->getPath();
	}

	/**
	 * Get destination file.
	 *
	 * @param  string $file
	 * @return string
	 */
	protected function getDestinationFile($file)
	{
		return $this->getModulePath($this->slug).$this->formatContent($file);
	}

	/**
	 * Get stub content by key.
	 *
	 * @param  int $key
	 * @return string
	 */
	protected function getStubContent($key, $blank = false)
	{
		if ( $blank ) {
			return $this->formatContent($this->finder->get(__DIR__.'/../../Stubs/Modules/'.$this->blankStubs[$key]));
		}
		return $this->formatContent($this->finder->get(__DIR__.'/../../Stubs/Modules/'.$this->stubs[$key]));
	}

	/**
	 * Replace placeholder text with correct values.
	 *
	 * @return string
	 */
	protected function formatContent($content)
	{
		return str_replace(
			['{{slug}}', '{{name}}', '{{module}}', '{{namespace}}', '{{singular}}', '{{model}}'],
			[$this->slug, studly_case($this->name), studly_case($this->slug), $this->module->getNamespace(), str_singular($this->name), str_singular(studly_case($this->name))],
			$content
		);
	}
}
