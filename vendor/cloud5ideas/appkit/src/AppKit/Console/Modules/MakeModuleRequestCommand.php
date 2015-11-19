<?php namespace C5\AppKit\Console\Modules;

use C5\AppKit\Handlers\Modules\MakeModuleRequestHandler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/modules
 */
class MakeModuleRequestCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:make:module:request';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Create a new module form request class';

	/**
	 * @var \C5\AppKit\Handlers\Modules\MakeModuleRequestHandler
	 */
	protected $handler;

	/**
	 * Create a new command instance.
	 *
	 * @param \C5\AppKit\Handlers\Modules\MakeModuleRequestHandler $handler
	 */
	public function __construct(MakeModuleRequestHandler $handler)
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
		return $this->handler->fire($this, $this->argument('module'), $this->argument('name'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['module', InputArgument::REQUIRED, 'The slug of the module'],
			['name', InputArgument::REQUIRED, 'The name of the class']
		];
	}
}
