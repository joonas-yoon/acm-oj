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
class MakeModuleMigrationHandler
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
	 * @var string $table The name of the table
	 */
	protected $table;

	/**
	 * @var string $model The name of the model
	 */
	protected $model;

	/**
	 * @var string $migrationName The name of the migration
	 */
	protected $migrationName;

	/**
	 * @var string $className The name of the migration class
	 */
	protected $className;

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
	 * @param  \C5\AppKit\Console\ModuleMakeMigrationCommand $console
	 * @param  string                                                  $slug
	 * @return string
	 */
	public function fire(Command $console, $slug, $table)
	{
		$this->console       = $console;
		$this->moduleName    = studly_case($slug);
		$this->table         = str_plural(strtolower($table));
		$this->model         = str_singular(studly_case($table));
		$this->migrationName = 'create_'.snake_case($this->table).'_table';
		$this->className     = studly_case($this->migrationName);

		if ($this->module->exists($this->moduleName)) {
			$this->makeMigration();
			$this->makeModel();

			$this->console->info("Created Module Migration: [$this->moduleName] ".$this->getFilename());

			return exec('composer dump-autoload');
		}

		return $this->console->info("Module [$this->moduleName] does not exist.");
	}

	/**
	 * Create new migration file.
	 *
	 * @return int
	 */
	protected function makeMigration()
	{
		return $this->finder->put($this->getMigrationDestinationFile(), $this->getStubContent());
	}

	/**
	 * Create new model file.
	 *
	 * @return int
	 */
	protected function makeModel()
	{
		return $this->finder->put($this->getModelDestinationFile(), $this->getStubContent('model'));
	}

	/**
	 * Get file destination for migration.
	 *
	 * @return string
	 */
	protected function getMigrationDestinationFile()
	{
		return $this->getPath().$this->formatMigrationContent($this->getFilename());
	}

	/**
	 * Get file destination for model.
	 *
	 * @return string
	 */
	protected function getModelDestinationFile()
	{
		return $this->getPath('model').$this->formatModelContent($this->getFilename('model'));
	}

	/**
	 * Get module migration/ model path.
	 *
	 * @return string
	 */
	protected function getPath($dir = 'migration')
	{
		$path = $this->module->getModulePath($this->moduleName);

		if($dir == 'model') {
			return $path;
		}

		return $path.'Database/Migrations/';
	}

	/**
	 * Get migration/ model filename.
	 *
	 * @return string
	 */
	protected function getFilename($file = 'migration')
	{
		if($file == 'model') {
			return $this->model.'.php';
		}
		return date("Y_m_d_His").'_'.$this->migrationName.'.php';
	}

	/**
	 * Get stub content.
	 *
	 * @return string
	 */
	protected function getStubContent($stub = 'migration')
	{
		if($stub == 'model') {
			return $this->formatModelContent($this->finder->get(__DIR__.'/../../Stubs/Modules/ModuleModel.stub'));
		}
		return $this->formatMigrationContent($this->finder->get(__DIR__.'/../../Stubs/Modules/ModuleMigration.stub'));
	}

	/**
	 * Replace placeholder text with correct values.
	 *
	 * @param  string $content
	 * @return string
	 */
	protected function formatMigrationContent($content)
	{
		return str_replace(
			['{{migrationName}}', '{{table}}'],
			[$this->className, $this->table],
			$content
		);
	}

	/**
	 * Replace placeholder text with correct values.
	 *
	 * @param  string $content
	 * @return string
	 */
	protected function formatModelContent($content)
	{
		return str_replace(
			['{{namespace}}', '{{moduleName}}', '{{className}}', '{{table}}'],
			[$this->module->getNamespace(), $this->moduleName, $this->model, $this->table],
			$content
		);
	}
}
