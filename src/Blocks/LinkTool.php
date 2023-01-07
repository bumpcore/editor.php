<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;

class LinkTool implements Provider
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('link', 'url'),
            Field::make('meta.title', 'string'),
            Field::make('meta.site_name', 'string'),
            Field::make('meta.description', 'string'),
            Field::make('meta.image.url', 'url'),
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
        return view('editor.php::linktool')
            ->with(compact('data'))
            ->render();
    }
}
