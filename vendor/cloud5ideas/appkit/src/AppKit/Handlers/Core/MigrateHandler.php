<?php namespace C5\AppKit\Handlers\Core;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class MigrateHandler
{
	/**
	 * @var Console
	 */
	protected $console;


	/**
	 * Constructor method.
	 *
	 */
	public function __construct()
	{

	}

	/**
	 * Fire off the handler.
	 *
	 * @param  \C5\AppKit\Console\Migrate*Command $console
	 * @param  string $name
	 * @return bool
	 */
	public function fire(Command $console, $action, $options)
	{
		$this->console = $console;

		switch ($action) {
			case 'migrate':
				$this->runMigrations($options);
				break;
			case 'refresh':
				$this->runRefreshMigrations($options);
				break;
			case 'reset':
				$this->runResetMigrations($options);
				break;
			case 'rollback':
				$this->runRollbackMigrations($options);
				break;	
			default:
				$this->runMigrations();
				break;
		}
	}

	/**
	 * Run all application and module migrations.
	 *
	 * @return void
	 */
	protected function runMigrations($options)
	{
		$this->console->call('migrate', $options);
		$this->console->callsilent('appkit:migrate:module', $options);
	}

	/**
	 * Refresh all application and module migrations.
	 *
	 * @return void
	 */
	protected function runRefreshMigrations($options)
	{
		$this->console->call('migrate:refresh', $options);
		$this->console->callsilent('appkit:migrate:refresh:module', $options);
	}

	/**
	 * Reset all application and module migrations.
	 *
	 * @return void
	 */
	protected function runResetMigrations($options)
	{
		$this->console->call('migrate:reset', $options);
		$this->console->callsilent('appkit:migrate:reset:module', $options);
	}

	/**
	 * Rollback all application and module migrations.
	 *
	 * @return void
	 */
	protected function runRollbackMigrations($options)
	{
		$this->console->call('migrate:rollback', $options);
		$this->console->callsilent('appkit:migrate:rollback:module', $options);
	}

}
