<?php

namespace BumpCore\EditorPhp\DTO;

class EditorPhpSettings
{
    public bool $ignoreUnknownBlocks = false;

    public function __construct(array $data = [])
    {
        $ref = new \ReflectionClass($this);

        foreach ($data as $key => $value) {
            if ($ref->hasProperty($key)) {
                $this->{$key} = $value;
            }
        }
    }
}

