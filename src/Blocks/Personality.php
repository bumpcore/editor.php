<?php

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;
use BumpCore\EditorPhp\Contracts\Provider;
use BumpCore\EditorPhp\Helpers;
use Illuminate\Support\Facades\View;

class Personality implements Provider
{
    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Field::make('name', 'string'),
            Field::make('description', 'string'),
            Field::make('link', 'url'),
            Field::make('photo', 'url'),
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
            return view('editor.php::personality')
                ->with(compact('data'))
                ->render();
        }

        return Helpers::renderNative(__DIR__ . '/../../resources/php/personality.php', compact('data'));
    }
}
