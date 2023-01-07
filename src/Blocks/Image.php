<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;

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
        return view('editor.php::image')
            ->with(compact('data'))
            ->render();
    }
}
