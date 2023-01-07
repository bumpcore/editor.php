<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;

class Embed implements Provider
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('service', 'string'),
            Field::make('source', 'url'),
            Field::make('embed', 'url'),
            Field::make('width', 'numeric'),
            Field::make('height', 'numeric'),
            Field::make('caption', 'string'),
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
        return view('editor.php::embed')
            ->with(compact('data'))
            ->render();
    }
}
