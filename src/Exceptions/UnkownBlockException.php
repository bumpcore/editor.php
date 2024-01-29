<?php

namespace BumpCore\EditorPhp\Exceptions;

use Exception;

class UnkownBlockException extends Exception
{
    public function __construct(string $block)
    {
        parent::__construct("Unknown block: {$block}");
    }
}
