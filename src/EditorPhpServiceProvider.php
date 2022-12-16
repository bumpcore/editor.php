<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Blocks\Delimiter;
use BumpCore\EditorPhp\Blocks\Header;
use BumpCore\EditorPhp\Blocks\Image;
use BumpCore\EditorPhp\Blocks\ListBlock;
use BumpCore\EditorPhp\Blocks\Paragraph;
use BumpCore\EditorPhp\Console\BlockMakeCommand;
use BumpCore\EditorPhp\Facades\EditorPhp as EditorPhpFacade;
use Illuminate\Support\ServiceProvider;

class EditorPhpServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(EditorPhp::class, fn () => new EditorPhp());
    }

    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                BlockMakeCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'editor.php');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/editor.php'),
        ], 'editor.php');

        EditorPhpFacade::register([
            Delimiter::class,
            Header::class,
            Image::class,
            ListBlock::class,
            Paragraph::class,
        ]);
    }
}
