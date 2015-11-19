<?php namespace C5\AppKit\Console\Modules;

use C5\AppKit\Modules\Modules;
use C5\AppKit\Traits\MigrationTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/modules
 */
class MigrateRollbackModuleCommand extends Command
{
	use MigrationTrait;

	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:migrate:rollback:module';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Rollback the last database migrations for a specific or all modules';

	/**
	 * @var \C5\AppKit\Modules\Modules
	 */
	protected $module;

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
		$module = $this->argument('module');

		if ($module) {
			return $this->rollback($module);
		} else {
			foreach ($this->module->all() as $module) {
				$this->rollback($module['slug']);
			}
		}
	}

	/**
	 * Run the migration rollback for the specified module.
	 *
	 * @param  string $slug
	 * @return mixed
	 */
	protected function rollback($slug)
	{
		$moduleName = studly_case($slug);

		$this->requireMigrations($moduleName);

		$this->call('appkit:migrate:rollback:module', [
			'--database' => $this->option('database'),
			'--force'    => $this->option('force'),
			'--pretend'  => $this->option('pretend'),
		]);
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
			['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
			['force', null, InputOption::VALUE_NONE, 'Force the operation to run while in production.'],
			['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.']
		];
	}
}
