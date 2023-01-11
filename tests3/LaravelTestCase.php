<?php

namespace BumpCore\EditorPhp\Tests;

use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\EditorPhpServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            EditorPhpServiceProvider::class,
        ];
    }

    /**
     * Define routes setup.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
		$router->get('/editor', function() {
			return EditorPhp::make(file_get_contents(__DIR__ . '/Datasets/sample.json'));
		});
    }
}
