<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Console\BlockMakeCommand;
use Illuminate\Support\ServiceProvider;

class EditorPhpServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        // ...
    }

    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            $this->commands(BlockMakeCommand::class);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'editor.php');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/editor.php'),
        ], 'editor.php');

        $this->publishes([
            __DIR__ . '/../config/editor.php' => config_path('editor.php'),
        ]);

        Parser::register(config('editor.blocks') ?? [], !empty(config('editor.blocks')));
    }
}
