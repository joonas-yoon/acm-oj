<?php namespace C5\AppKit\Console\Core;

use C5\AppKit\Handlers\Core\MigrateHandler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class MigrateRollbackCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:migrate:rollback';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Rollback the last application and module migration operation.';

	/**
	 * @var \C5\AppKit\Handlers\Core\MigrateHandler
	 */
	protected $handler;

	/**
	 * Create a new command instance.
	 *
	 * @param \C5\AppKit\Handlers\Core\MigrateHandler $handler
	 */
	public function __construct(MigrateHandler $handler)
	{
		parent::__construct();
		$this->handler = $handler;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		return $this->handler->fire($this, 'rollback', $this->getFormattedOptions());
	}

	/**
	 * Format options into usable array.
	 *
	 * @return array
	 **/
	protected function getFormattedOptions() {
		$options = array();
		$options['--database'] = $this->option('database');
		$options['--force'] = $this->option('force');
		$options['--pretend'] = $this->option('pretend');
		return $options;
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
			['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.'],
		];
	}
}
