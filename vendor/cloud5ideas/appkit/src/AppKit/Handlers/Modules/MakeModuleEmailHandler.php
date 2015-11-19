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
class MakeModuleEmailHandler
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
	 * @var string $emailName The name of the email view
	 */
	protected $emailName;

	/**
	 * @var string $type The type of email
	 */
	protected $type;

	/**
	 * Constructor method.
	 *
	 * @param \C5\AppKit\Modules\Modules      $module
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
	public function fire(Command $console, $slug, $name, $type)
	{
		$this->console      = $console;
		$this->moduleName   = studly_case($slug);
		$this->emailName    = snake_case($name);
		$this->type			= $type;

		if ($this->module->exists($this->moduleName)) {
			$this->makeFile();

			return $this->console->info("Created Module Email View: [$this->moduleName] ".$this->getFilename());
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
		return $this->getPath().$this->getFilename();
	}

	/**
	 * Get module migration path.
	 *
	 * @return string
	 */
	protected function getPath()
	{
		$path = $this->module->getModulePath($this->moduleName);

		return $path.'Resources/Views/Emails/';
	}

	/**
	 * Get migration filename.
	 *
	 * @return string
	 */
	protected function getFilename()
	{
		return $this->emailName.'.blade.php';
	}

	/**
	 * Get stub content.
	 *
	 * @return string
	 */
	protected function getStubContent()
	{
		return $this->finder->get(__DIR__.'/../../Stubs/Emails/'.$this->type.'.stub');
	}
}
