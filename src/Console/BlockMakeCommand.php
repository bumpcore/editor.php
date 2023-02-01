<?php

namespace BumpCore\EditorPhp\Console;

use Illuminate\Console\GeneratorCommand;

class BlockMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:block {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Editor.php block class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/block.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Blocks';
    }
}
