<?php namespace C5\AppKit\Console\Modules;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/modules
 */
class DisableModuleCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:disable:module';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Disable a module';

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$module = $this->argument('module');

		if ($this->laravel['modules']->isEnabled($this->argument('module'))) {
			$this->laravel['modules']->disable($module);

			$this->info("Module [{$module}] was disabled successfully.");
		} else {
			$this->comment("Module [{$module}] is already disabled.");
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['module', InputArgument::REQUIRED, 'Module slug.']
		];
	}
}
