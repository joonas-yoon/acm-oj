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
class MakeModuleRequestHandler
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
	 * @var string $className The name of the request class
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

			return $this->console->info("Created Module Form Request: [$this->moduleName] ".$this->getFilename());
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

		return $path.'Http/Requests/';
	}

	/**
	 * Get migration filename.
	 *
	 * @return string
	 */
	protected function getFilename()
	{
		return studly_case($this->className).'.php';
	}

	/**
	 * Get stub content.
	 *
	 * @return string
	 */
	protected function getStubContent()
	{
		return $this->formatContent($this->finder->get(__DIR__.'/../../Stubs/Modules/ModuleRequest.stub'));
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
			['{{className}}', '{{moduleName}}', '{{namespace}}'],
			[$this->className, $this->moduleName, $this->module->getNamespace()],
			$content
		);
	}
}
