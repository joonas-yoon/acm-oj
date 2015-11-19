<?php namespace C5\AppKit\Console\Modules;

use C5\AppKit\Handlers\Modules\MakeModuleEmailHandler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class MakeModuleEmailCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:make:module:email';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Create a new email view for a module';

	/**
	 * @var \C5\AppKit\Handlers\Modules\MakeModuleEmailHandler
	 */
	protected $handler;

	/**
	 * Create a new command instance.
	 *
	 * @param \C5\AppKit\Handlers\Modules\MakeModuleEmailHandler $handler
	 */
	public function __construct(MakeModuleEmailHandler $handler)
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
		return $this->handler->fire($this,$this->argument('module'), $this->argument('name'), $this->argument('type'));
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
			['name', InputArgument::REQUIRED, 'Name of the email.'],
			['type', InputArgument::REQUIRED, 'Type of email. [action|alert|billing]']
		];
	}
}
