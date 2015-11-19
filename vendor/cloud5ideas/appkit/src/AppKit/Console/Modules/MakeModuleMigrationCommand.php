<?php namespace C5\AppKit\Console\Modules;

use C5\AppKit\Handlers\Modules\MakeModuleMigrationHandler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/modules
 */
class MakeModuleMigrationCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:make:module:migration';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Create a new module migration file';

	/**
	 * @var \C5\AppKit\Handlers\Modules\MakeModuleMigrationHandler
	 */
	protected $handler;

	/**
	 * Create a new command instance.
	 *
	 * @param \C5\AppKit\Handlers\Modules\MakeModuleMigrationHandler $handler
	 */
	public function __construct(MakeModuleMigrationHandler $handler)
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
		return $this->handler->fire($this, $this->argument('module'), $this->argument('table'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['module', InputArgument::REQUIRED, 'Module slug.'],
			['table', InputArgument::REQUIRED, 'Table name.']
		];
	}
}
