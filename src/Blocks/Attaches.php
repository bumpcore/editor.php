<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;

class Attaches implements Provider
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('title', 'string'),
            Field::make('file.url', 'url'),
            Field::make('file.size', 'numeric'),
            Field::make('file.name', 'string'),
            Field::make('file.extension', 'string'),
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
        return view('editor.php::attaches')
            ->with(compact('data'))
            ->render();
    }
}
