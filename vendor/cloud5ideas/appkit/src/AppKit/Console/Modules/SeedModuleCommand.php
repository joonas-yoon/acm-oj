<?php namespace C5\AppKit\Console\Modules;

use C5\AppKit\Modules\Modules;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/modules
 */
class SeedModuleCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:seed:module';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Seed the database with records for a specific or all modules';

	/**
	 * @var \C5\AppKit\Modules\Modules
	 */
	protected $module;

	/**
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $finder;


	/**
	 * Create a new command instance.
	 *
	 * @param \C5\AppKit\Modules\Modules $module
	 */
	public function __construct(Modules $module)
	{
		parent::__construct();

		$this->module = $module;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$module     = $this->argument('module');
		$moduleName = studly_case($module);

		if (isset($module)) {
			if ($this->module->exists($moduleName)) {
				$this->seed($module);

				return;
			}

			return $this->error("Module [$moduleName] does not exist.");
		} else {
			foreach ($this->module->all() as $module) {
				$this->seed($module['slug']);
			}
		}
	}

	/**
	 * Seed the specific module.
	 *
	 * @param  string $module
	 * @return array
	 */
	protected function seed($module)
	{
		$params     = array();
		$moduleName = studly_case($module);
		$namespace  = $this->module->getNamespace();
		$rootSeeder = $moduleName.'DatabaseSeeder';
		$fullPath   = $namespace.$moduleName.'\Database\Seeds\\'.$rootSeeder;

		if (\File::exists(base_path($fullPath.'.php'))) {
			if ($this->option('class')) {
				$params['--class'] = $this->option('class');
			} else {
				$params['--class'] = $fullPath;
			}

			if ($option = $this->option('database')) {
				$params['--database'] = $option;
			}

			$this->call('db:seed', $params);
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [['module', InputArgument::OPTIONAL, 'Module slug.']];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the module\'s root seeder.'],
			['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed.']
		];
	}
}
