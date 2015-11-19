<?php namespace C5\AppKit\Handlers\Modules;

use C5\AppKit\Modules\Modules;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class MakeModuleControllerHandler
{
	/**
	 * @var \C5\AppKit\Modules\Modules
	 */
	protected $module;

	/**
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $finder;

	/**
	 * @var \Illuminate\Console\Command
	 */
	protected $console;

	/**
	 * @var string $moduleName The name of the module
	 */
	protected $moduleName;

	/**
	 * @var string $className The name of the controller class
	 */
	protected $className;

	/**
	 * Constructor method.
	 *
	 * @param \C5\AppKit\Modules\Modules     $module
	 * @param \Illuminate\Filesystem\Filesystem $finder
	 */
	public function __construct(Modules $module, Filesystem $finder)
	{
		$this->module = $module;
		$this->finder = $finder;
	}

	/**
	 * Fire off the handler.
	 *
	 * @param  \Illuminate\Console\Command $console
	 * @param  string                      $slug
	 * @param  string                      $class
	 * @return bool
	 */
	public function fire(Command $console, $slug, $class)
	{
		$this->console       = $console;
		$this->moduleName    = studly_case($slug);
		$this->className     = studly_case($class);

		if ($this->module->exists($this->moduleName)) {
			$this->makeFile();

			return $this->console->info("Created Module Controller: [$this->moduleName] ".$this->getFilename());
		}

		return $this->console->info("Module [$this->moduleName] does not exist.");
	}

	/**
	 * Create new migration file.
	 *
	 * @return int
	 */
	protected function makeFile()
	{
		return $this->finder->put($this->getDestinationFile(), $this->getStubContent());
	}

	/**
	 * Get file destination.
	 *
	 * @return string
	 */
	protected function getDestinationFile()
	{
		return $this->getPath().$this->formatContent($this->getFilename());
	}

	/**
	 * Get module migration path.
	 *
	 * @return string
	 */
	protected function getPath()
	{
		$path = $this->module->getModulePath($this->moduleName);

		return $path.'Http/Controllers/';
	}

	/**
	 * Get migration filename.
	 *
	 * @return string
	 */
	protected function getFilename()
	{
		return studly_case($this->className).'Controller.php';
	}

	/**
	 * Get stub content.
	 *
	 * @return string
	 */
	protected function getStubContent()
	{
		return $this->formatContent($this->finder->get(__DIR__.'/../../Stubs/Modules/ModuleController.stub'));
	}

	/**
	 * Replace placeholder text with correct values.
	 *
	 * @param  string $content
	 * @return string
	 */
	protected function formatContent($content)
	{
		return str_replace(
			['{{name}}', '{{module}}', '{{slug}}', '{{namespace}}', '{{singular}}', '{{model}}'],
			[$this->className, $this->moduleName, strtolower($this->moduleName), $this->module->getNamespace(), strtolower(str_singular($this->className)), str_singular(studly_case($this->className))],
			$content
		);
	}
}
