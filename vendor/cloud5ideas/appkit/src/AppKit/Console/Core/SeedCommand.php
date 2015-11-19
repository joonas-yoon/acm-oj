<?php namespace C5\AppKit\Console\Core;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class SeedCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:seed';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Run all application and module database seeders.';

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
		$this->call('db:seed', $this->getFormattedOptions());
		$this->call('appkit:seed:module', $this->getFormattedOptions());
	}

	/**
	 * Format options into usable array.
	 *
	 * @return array
	 **/
	protected function getFormattedOptions() {
		$options = array();
		$options['--class'] = $this->option('class');
		$options['--database'] = $this->option('database');
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
			['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the module\'s root seeder.'],
			['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed.']
		];
	}
}
