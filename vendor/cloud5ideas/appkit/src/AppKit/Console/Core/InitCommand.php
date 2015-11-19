<?php namespace C5\AppKit\Console\Core;

use C5\AppKit\Handlers\Core\InitHandler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class InitCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:init';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Initialize AppKit';

	/**
	 * @var \C5\AppKit\Handlers\Core\InitHandler
	 */
	protected $handler;

	/**
	 * Create a new command instance.
	 *
	 * @param \C5\AppKit\Handlers\Core\InitHandler $handler
	 */
	public function __construct(InitHandler $handler)
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
		return $this->handler->fire($this, $this->argument('name'), $this->argument('assets'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'Name of your application.'],
			['assets', InputArgument::REQUIRED, 'Publish less|sass assets.']
		];
	}
}
