<?php

namespace BumpCore\EditorPhp\Tests;

use BumpCore\EditorPhp\EditorPhpServiceProvider;
use Illuminate\Console\Command;
use Orchestra\Testbench\TestCase;

class LaravelTestCase extends TestCase
{
	protected function getPackageProviders($app)
	{
		return [
			EditorPhpServiceProvider::class,
		];
	}
}
