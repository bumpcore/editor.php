<?php

namespace BumpCore\EditorPhp\Tests\Laravel;

use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\EditorPhpServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
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
        $router->get('/', function() {
            return EditorPhp::make(file_get_contents(__DIR__ . '/../Datasets/samples/valid.json'));
        });
    }
}
