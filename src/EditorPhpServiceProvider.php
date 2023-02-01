<?php

namespace BumpCore\EditorPhp;

use BumpCore\EditorPhp\Console\BlockMakeCommand;
use Illuminate\Support\ServiceProvider;

class EditorPhpServiceProvider extends ServiceProvider
{
    public static array $blocks = [
        \BumpCore\EditorPhp\Blocks\Attaches::class,
        \BumpCore\EditorPhp\Blocks\Checklist::class,
        \BumpCore\EditorPhp\Blocks\Code::class,
        \BumpCore\EditorPhp\Blocks\Delimiter::class,
        \BumpCore\EditorPhp\Blocks\Embed::class,
        \BumpCore\EditorPhp\Blocks\Header::class,
        \BumpCore\EditorPhp\Blocks\Image::class,
        \BumpCore\EditorPhp\Blocks\LinkTool::class,
        \BumpCore\EditorPhp\Blocks\ListBlock::class,
        \BumpCore\EditorPhp\Blocks\Paragraph::class,
        \BumpCore\EditorPhp\Blocks\Personality::class,
        \BumpCore\EditorPhp\Blocks\Quote::class,
        \BumpCore\EditorPhp\Blocks\Raw::class,
        \BumpCore\EditorPhp\Blocks\Table::class,
        \BumpCore\EditorPhp\Blocks\Warning::class,
    ];

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

        Parser::register(static::$blocks);
    }
}
