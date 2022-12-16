<?php

namespace BumpCore\EditorPhp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void register(array $providers)
 * @method static \BumpCore\EditorPhp\EditorPhp load(string $output)
 */
class EditorPhp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \BumpCore\EditorPhp\EditorPhp::class;
    }
}
