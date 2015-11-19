<?php namespace C5\AppKit\Console\Core;

use C5\AppKit\Handlers\Core\InitHandler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class PublishCommand extends Command
{
	/**
	 * @var string $name The console command name.
	 */
	protected $name = 'appkit:publish';

	/**
	 * @var string $description The console command description.
	 */
	protected $description = 'Publish AppKit Assets';

	/**
	 * Create a new command instance.
	 *
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
		$asset = $this->option('tag');
		if (isset($asset)) {
			$this->call('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider', '--tag' => $asset]);
		} else {
			$this->call('vendor:publish', ['--provider' => 'C5\AppKit\AppKitServiceProvider']);
		}
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['tag',null, InputOption::VALUE_OPTIONAL, 'config|migrations|models|modules|less|sass|js']
		];
	}	
}
