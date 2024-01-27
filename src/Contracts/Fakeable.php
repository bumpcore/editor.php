<?php

namespace BumpCore\EditorPhp\Contracts;

use Faker\Generator;

interface Fakeable
{
    /**
     * Generates fake data for the block.
     *
     * @param Generator $generator
     *
     * @return mixed
     */
    public static function fake(Generator $generator): mixed;
}
