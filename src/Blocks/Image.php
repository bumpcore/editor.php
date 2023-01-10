<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Image implements Provider
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('file.url', 'url'),
            Field::make('caption', 'string'),
            Field::make('withBorder', 'boolean'),
            Field::make('stretched', 'boolean'),
            Field::make('withBackground', 'boolean'),
        ];
    }

    /**
     * Renderer for the block.
     *
     * @param Data $data
     *
     * @return string
     */
    public function render(Data $data): string
    {
        if (View::getFacadeRoot())
        {
            return view('editor.php::image')
                ->with(compact('data'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/views/php/image.php', compact('data'));
    }
}
