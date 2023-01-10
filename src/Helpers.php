<?php

namespace BumpCore\EditorPhp;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Filesystem;
use Illuminate\Support\Facades;
use Illuminate\Translation;
use Illuminate\Validation;

class Helpers
{
    /**
     * Creates new validator instance.
     *
     * @param array $data
     * @param array $rules
     *
     * @return Validator
     */
    public static function makeValidator(array $data, array $rules): Validator
    {
        if (Facades\Validator::getFacadeRoot())
        {
            return Facades\Validator::make($data, $rules);
        }

        // ! Not a perfect way to using validator.
        return (new Validation\Factory(new Translation\Translator(new Translation\FileLoader(new Filesystem\Filesystem(), ''), 'en_US')))
            ->make($data, $rules);
    }

    /**
     * Basic renderer to render native templates.
     *
     * @param string $file
     * @param array $data
     *
     * @return string
     */
    public static function renderNative(string $file, array $data): string
    {
        ob_start();
        extract($data);
        require $file;

        return ob_get_clean();
    }
}
