<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

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
        if (View::getFacadeRoot())
        {
            return view('editor.php::linktool')
                ->with(compact('data'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/views/php/linktool.php', compact('data'));
    }
}
